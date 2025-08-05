<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 23.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\OrderRepository;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Urgent\Base\Api\AwbRepositoryInterface;
use Urgent\Base\Api\CityRepositoryInterface;
use Urgent\Base\Api\CountyRepositoryInterface;
use Urgent\Base\Api\Data\AwbInterface;
use Urgent\Base\Api\Data\AwbInterfaceFactory;
use Urgent\Base\Api\Data\CityInterface;
use Urgent\Base\Api\Data\CountyInterface;
use Urgent\Base\Logger\Logger;
use Urgent\Base\Model\Config\Config;
use Urgent\Base\Model\Config\Source\Payer;
use Urgent\Base\Model\Helper\Diacritics;
use Urgent\Base\Model\Helper\PrepareData;

/**
 * Class AddAwbGrid
 *
 * Description: Class that add info about the order on the table urgent_cargus_awb to create awb after.
 */
class AddAwbGrid
{
    protected const RO_CURRENCY = 'RON';

    /** @var AwbInterfaceFactory $_awbInterfaceFactory */
    protected AwbInterfaceFactory $_awbInterfaceFactory;
    /** @var AwbRepositoryInterface $_awbRepository */
    protected AwbRepositoryInterface $_awbRepository;
    /** @var OrderRepository $_orderRepository */
    protected OrderRepository $_orderRepository;
    /** @var Config $_config */
    protected Config $_config;
    /** @var StoreManagerInterface $_storeManager */
    protected StoreManagerInterface $_storeManager;
    /** @var ScopeConfigInterface $_scopeConfig */
    protected ScopeConfigInterface $_scopeConfig;
    /** @var Logger $_logger */
    protected Logger $_logger;
    /** @var Diacritics $_diacritics */
    protected Diacritics $_diacritics;
    /** @var CountyRepositoryInterface $_countyRepository */
    protected CountyRepositoryInterface $_countyRepository;
    /** @var ResourceConnection $_resourceConnection */
    protected ResourceConnection $_resourceConnection;
    /** @var PrepareData $_prepareData */
    protected PrepareData $_prepareData;

    /**
     * Constructor
     *
     * @param AwbInterfaceFactory $awbInterfaceFactory
     * @param AwbRepositoryInterface $awbRepository
     * @param OrderRepository $orderRepository
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param Logger $logger
     * @param Diacritics $diacritics
     * @param CountyRepositoryInterface $countyRepository
     * @param ResourceConnection $resourceConnection
     * @param PrepareData $prepareData
     */
    public function __construct(
        AwbInterfaceFactory $awbInterfaceFactory,
        AwbRepositoryInterface $awbRepository,
        OrderRepository $orderRepository,
        Config $config,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        Logger $logger,
        Diacritics $diacritics,
        CountyRepositoryInterface $countyRepository,
        ResourceConnection $resourceConnection,
        PrepareData $prepareData
    ) {
        $this->_awbInterfaceFactory = $awbInterfaceFactory;
        $this->_awbRepository = $awbRepository;
        $this->_orderRepository = $orderRepository;
        $this->_config = $config;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_logger = $logger;
        $this->_diacritics = $diacritics;
        $this->_countyRepository = $countyRepository;
        $this->_resourceConnection = $resourceConnection;
        $this->_prepareData = $prepareData;
    }

    /**
     * Method execute
     *
     * @param OrderInterface $order
     * @return bool
     * @throws NoSuchEntityException
     */
    public function execute(OrderInterface $order): bool
    {
        if (!$order->getIncrementId() || $this->existOrderInAwb($order->getIncrementId())) {
            return false;
        }
        $grandTotal = $order->getGrandTotal();
        if ($order->getOrderCurrencyCode() !== $this::RO_CURRENCY) {
            $defaultCurrency = $this->_storeManager->getStore()->getCurrentCurrencyCode();
            $allowedCurrencies = $this->_storeManager->getStore()->getAllowedCurrencies();

            $rates = $this->_storeManager->getStore()->getBaseCurrency()
                ->getCurrencyRates($defaultCurrency, $allowedCurrencies);

            // workaround for some magento versions, where base currency is missing
            if (!isset($rates[self::RO_CURRENCY])) {
                $rates['RON'] = "1.000000000000";
            }

            $baseToRon = $rates['RON'] / $rates[$order->getBaseCurrencyCode()];
            $grandTotal *= $baseToRon;
        }

        $payer = $this->_config->getGeneralPayer();
        if ($payer === Payer::CONSIGNEE) {
            $grandTotal = ($grandTotal - $order->getShippingAmount()) - $order->getShippingTaxAmount();
        }

        if ($order->getShippingAmount() === 0) {
            $payer = Payer::SENDER;
        }

        $declaredValue = 0;
        if ($this->_config->getGeneralInsurance()) {
            $declaredValue = $grandTotal;
        }

        $paymentMethod = $order->getPayment()->getMethod();
        $shippingMethod = $order->getShippingMethod();
        $shippingMethodLen = (int)ceil(strlen($shippingMethod) / 2);
        $configShippingPath = 'carriers/' . substr($shippingMethod, $shippingMethodLen) . '/specific_payment';
        $shippingMethodPaymentsConfig = $this->_scopeConfig->getValue($configShippingPath, ScopeInterface::SCOPE_STORE);
        if ($shippingMethodPaymentsConfig !== null) {
            $shippingMethodPaymentsConfig = explode(',', $shippingMethodPaymentsConfig);
            if (in_array($paymentMethod, $shippingMethodPaymentsConfig, true)) {
                $grandTotal = 0;
            }
        }

        $weight = round((float)$order->getWeight());
        try {
            if ($weight <= 0) {
                $weight = $this->_config->getDVWeight() > 0 ? $this->_config->getDVWeight() : 1;
            }

            $shippingAddress = $order->getShippingAddress();
            $recipientName = $shippingAddress->getFirstname() . ' ' . $shippingAddress->getLastname();
            /** @var AwbInterface $awb */
            $awb = $this->_awbInterfaceFactory->create();
            $awb->setOrderId($order->getIncrementId());
            $awb->setPickupLocationId($this->_config->getGeneralLiftingPoint());
            $awb->setPudoId((int)$shippingAddress->getPudoId());
            $awb->setRecipientName($shippingAddress->getCompany() ?? $recipientName);

            $destinationLocality = null;
            if ($order->getOrderCurrencyCode() === $this::RO_CURRENCY) {
                $destinationCounty = $this->_prepareData->getCargusCounty(
                    (int)$shippingAddress->getRegionId(),
                    $shippingAddress->getRegion()
                );

                if ($destinationCounty !== null && $destinationCounty->getId()) {
                    $destinationLocality = $this->_prepareData->getCargusCity(
                        $shippingAddress->getCity(),
                        (int)$destinationCounty->getId()
                    );
                    $awb->setCountyId((int)$destinationCounty->getId());
                    $awb->setDestinationCounty($destinationCounty->getName());
                } else {
                    $awb->setDestinationCounty($this->_diacritics->remove($shippingAddress->getRegion()));
                }

                if ($destinationLocality !== null && isset($destinationLocality[CityInterface::LOCALITY_ID])) {
                    $awb->setLocalityId((int)$destinationLocality[CityInterface::LOCALITY_ID]);
                    $awb->setDestinationLocality(ucfirst(strtolower($destinationLocality[CityInterface::NAME])));
                } else {
                    $awb->setDestinationLocality($this->_diacritics->remove($shippingAddress->getCity()));
                }
            } else {
                //scenario for external shipments
                $awb->setCountyId((int) $shippingAddress->getData('region_id'));
                $awb->setDestinationCounty($this->_diacritics->remove($shippingAddress->getData('region')));
                $awb->setLocalityId(0); //static value for external shipments
                $awb->setDestinationLocality($this->_diacritics->remove($shippingAddress->getData('city')));
            }

            $awb->setDestinationAddress(implode(',', $shippingAddress->getStreet()));
            $awb->setRecipientContact($recipientName);
            $awb->setRecipientPhone($shippingAddress->getTelephone() ?? '');
            $awb->setRecipientEmail($shippingAddress->getEmail() ?? '');
            $awb->setZipCode($destinationLocality !== null && $destinationCounty[CityInterface::POSTAL_CODE] > 0
                ? $destinationCounty[CityInterface::POSTAL_CODE] : $shippingAddress->getPostcode() ?? '');
            $awb->setEnvelope($weight > 1 ? 0 : $this->_config->getGeneralDefaultShipmentType());
            $awb->setParcel($weight > 1 ? 1 : (int)!$this->_config->getGeneralDefaultShipmentType());
            $awb->setWeight($weight > 0 ? (int)$weight : 1);
            $awb->setLength($this->_config->getDVLength());
            $awb->setWidth($this->_config->getDVWidth());
            $awb->setHeight($this->_config->getDVHeight());
            $awb->setDeclaredValue($declaredValue);
            $awb->setCashRefunds($this->_config->getGeneralRepayment() ? 0 : round((float)$grandTotal, 2));
            $awb->setAccountRefunds($this->_config->getGeneralRepayment() ? round((float)$grandTotal, 2) : 0);
            $awb->setShippingPayer($payer);
            $awb->setSaturdayDelivery((int)$this->_config->getGeneralSaturdayDelivery());
            $awb->setMorningDelivery((int)$this->_config->getGeneralMorningDelivery());
            $awb->setPackageOpening((int)$this->_config->getGeneralPackageOpening());
            $awb->setContent($this->getProductsName($order));

            $this->_awbRepository->save($awb);
        } catch (CouldNotSaveException $e) {
            if ($this->_config->getDebugLogger()) {
                $this->_logger->critical($e->getMessage());
            }
            return false;
        }
        return true;
    }

    /**
     * Method existOrderInAwb
     *
     * @param string|null $incrementId
     * @return bool
     */
    private function existOrderInAwb(?string $incrementId): bool
    {
        try {
            $awbExists = $this->_awbRepository->getByAwbOrderId((int)$incrementId);
            return (bool)$awbExists->getId();
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * Method getProductsName
     *
     * @param OrderInterface $order
     * @return string
     */
    private function getProductsName(OrderInterface $order): string
    {
        $result = '';
        foreach ($order->getItems() as $orderItem) {
            $result .= $orderItem->getName() . '; ';
        }
        return $result;
    }
}
