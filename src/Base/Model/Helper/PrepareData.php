<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 21.02.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Helper;

use Magento\Framework\App\ResourceConnection;
use Magento\Quote\Model\Quote;
use Magento\Store\Model\StoreManagerInterface;
use Urgent\Base\Api\CityRepositoryInterface;
use Urgent\Base\Api\CountyRepositoryInterface;
use Urgent\Base\Api\Data\CityInterface;
use Urgent\Base\Api\Data\CountyInterface;
use Urgent\Base\Logger\Logger;
use Urgent\Base\Model\Config\Config;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Urgent\Base\Model\Config\Source\Payer;

/**
 * Class PrepareData
 *
 * Description: ...
 */
class PrepareData
{
    protected const EXTERNAL_SERVICE_ID = 41;

    /** @var Logger $_logger */
    private Logger $_logger;
    /** @var Config $_config */
    private Config $_config;
    /** @var StoreManagerInterface $_storeManager */
    private StoreManagerInterface $_storeManager;
    /** @var CheckoutSession $_checkoutSession */
    private CheckoutSession $_checkoutSession;
    /** @var CartRepositoryInterface $_quoteRepository */
    private CartRepositoryInterface $_quoteRepository;
    /** @var CountyRepositoryInterface $_countyRepository */
    private CountyRepositoryInterface $_countyRepository;
    /** @var CityRepositoryInterface $_cityRepository */
    private CityRepositoryInterface $_cityRepository;
    /** @var Diacritics $_diacritics */
    private Diacritics $_diacritics;
    /** @var ResourceConnection $_resourceConnection */
    private ResourceConnection $_resourceConnection;

    /**
     * Constructor
     *
     * @param Logger $logger
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param CheckoutSession $checkoutSession
     * @param CartRepositoryInterface $quoteRepository
     * @param CountyRepositoryInterface $countyRepository
     * @param CityRepositoryInterface $cityRepository
     * @param Diacritics $diacritics
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        Logger                    $logger,
        Config                    $config,
        StoreManagerInterface     $storeManager,
        CheckoutSession           $checkoutSession,
        CartRepositoryInterface   $quoteRepository,
        CountyRepositoryInterface $countyRepository,
        CityRepositoryInterface   $cityRepository,
        Diacritics                $diacritics,
        ResourceConnection        $resourceConnection
    ) {
        $this->_logger = $logger;
        $this->_config = $config;
        $this->_storeManager = $storeManager;
        $this->_checkoutSession = $checkoutSession;
        $this->_quoteRepository = $quoteRepository;
        $this->_countyRepository = $countyRepository;
        $this->_cityRepository = $cityRepository;
        $this->_diacritics = $diacritics;
        $this->_resourceConnection = $resourceConnection;
    }

    /**
     * Method shippingCalcData
     *
     * @return array
     */
    public function shippingCalcData(): array
    {

        $quoteId = (int)$this->_checkoutSession->getQuoteId();
        if ($quoteId > 0) {
            try {
                /** @var Quote $quote */
                $quote = $this->_quoteRepository->get($quoteId);
                $quoteShippingAddress = $quote->getShippingAddress();
                $toCounty = $this->getCargusCounty(
                    (int)$quoteShippingAddress->getRegionId(),
                    $quoteShippingAddress->getRegion()
                );
                $toCity = null;
                if ($toCounty !== null && $toCounty->getId()) {
                    $toCity = $this->getCargusCity(
                        $quoteShippingAddress->getCity(),
                        (int)$toCounty->getId()
                    );
                }

                $fromCounty = $this->_config->getLocationCounty();
                $fromCity = $this->_config->getLocationCity();

                if ($fromCounty > 0 && $fromCity > 0 && $toCounty !== null && $toCounty->getId() && $toCity !== null) {

                    $fromCounty = $this->_countyRepository->getById($fromCounty);
                    /** @var CountyInterface $fromCounty */
                    $fromCity = $this->_cityRepository->getById($fromCity);
                    /** @var CityInterface $fromCounty */

                    $weight = round((float)$quoteShippingAddress->getWeight());

                    if ($weight <= 0) {
                        $weight = $this->_config->getDVWeight() > 0 ? $this->_config->getDVWeight() : 1;
                    }

                    $grandTotal = $quote->getGrandTotal();

                    if ($quote->getBaseCurrencyCode() !== 'RON') {
                        $defaultCurrency = $this->_storeManager->getStore()->getCurrentCurrencyCode();
                        $allowedCurrencies = $this->_storeManager->getStore()->getAllowedCurrencies();

                        $rates = $this->_storeManager->getStore()->getBaseCurrency()
                            ->getCurrencyRates($defaultCurrency, $allowedCurrencies);

                        $baseToRon = $rates['RON'] / $rates[$quote->getBaseCurrencyCode()];
                        $grandTotal *= $baseToRon;
                    }

                    $payer = $this->_config->getGeneralPayer();
                    if ($payer === Payer::CONSIGNEE) {
                        $grandTotal = ($grandTotal - $quoteShippingAddress->getShippingAmount()) - $quoteShippingAddress->getShippingTaxAmount();
                    }

                    $declaredValue = 0;
                    if ($this->_config->getGeneralInsurance()) {
                        $declaredValue = $grandTotal;
                    }

                    $repayment = $this->_config->getGeneralRepayment();
                    return [
                        'DeliveryPudoPoint' => (int)$quoteShippingAddress->getPudoId(),
                        'FromCountyName' => $fromCounty->getName(),
                        'ToCountyName' => $toCounty->getName(),
                        'FromLocalityId' => $fromCity->getId(),
                        'ToLocalityId' => $toCity[CityInterface::LOCALITY_ID],
                        'FromLocalityName' => $fromCity->getName(),
                        'ToLocalityName' => $toCity[CityInterface::NAME],
                        'Parcels' => $weight > 1 ? 1 : (int)!$this->_config->getGeneralDefaultShipmentType(),
                        'Envelopes' => $weight > 1 ? 0 : $this->_config->getGeneralDefaultShipmentType(),
                        'TotalWeight' => $weight,
                        'PriceTableId' => $this->_config->getGeneralPriceTable($quote->getStoreId()),
                        'ServiceId' => $this->_config->getGeneralService(),
                        'ShipmentPayer' => $payer,
                        'DeclaredValue' => $declaredValue,
                        'CashRepayment' => $repayment ? 0 : round((float)$grandTotal, 2),
                        'BankRepayment' => $repayment ? round((float)$grandTotal, 2) : 0,
                        'OtherRepayment' => '',
                        'PaymentInstrumentId' => 0,
                        'PaymentInstrumentValue' => 0,
                        'OpenPackage' => $this->_config->getGeneralPackageOpening(),
                        'SaturdayDelivery' => $this->_config->getGeneralSaturdayDelivery(),
                        'MorningDelivery' => $this->_config->getGeneralMorningDelivery(),
                        'ParcelCodes' => $this->getItemsData($quote->getAllItems())
                    ];
                }
            } catch (NoSuchEntityException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->debug('Shipping Calculation: ' . $e->getMessage());
                }
            }
        }
        return [];
    }

    /**
     * Method externalShippingCalcData
     *
     * @return array
     */
    public function externalShippingCalcData(): array
    {
        $quoteId = (int)$this->_checkoutSession->getQuoteId();

        if ($quoteId > 0) {
            try {
                $quote = $this->_quoteRepository->get($quoteId);

                $quoteShippingAddress = $quote->getShippingAddress();
                $fromCity = $this->_config->getLocationCity();
                $fromCity = $this->_cityRepository->getById($fromCity);
                $weight = round((float)$quoteShippingAddress->getWeight());
                if ($weight <= 0) {
                    $weight = $this->_config->getDVWeight() > 0 ? $this->_config->getDVWeight() : 1;
                }

                $grandTotal = $quote->getGrandTotal();
                $declaredValue = 0;
                if ($this->_config->getGeneralInsurance()) {
                    $declaredValue = $grandTotal;
                }

                return [
                    'agreementId' => $this->_config->getGeneralPriceTable($quote->getStoreId()),
                    'serviceId' => self::EXTERNAL_SERVICE_ID, //static value, for external shipments
                    'declaredValue' => $declaredValue,
                    'coDAmount' => 0,
                    'openPackage' => false,
                    'totalWeight' => $weight,
                    'parcels' => $weight > 1 ? 1 : (int)!$this->_config->getGeneralDefaultShipmentType(),
                    'envelopes' => $weight > 1 ? 0 : $this->_config->getGeneralDefaultShipmentType(),
                    'expCityId' => $fromCity->getId(),
                    'destCityId' => 0, //static value, for external shipments
                    'parcelCodes' => $this->getItemsData($quote->getAllItems(), true)
                ];
            } catch (NoSuchEntityException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->debug('External Shipping Calculation: ' . $e->getMessage());
                }
            }
        }
        return [];
    }

    /**
     * Method getItemsData
     *
     * @param $items
     * @param bool $external
     * @return array
     */
    private function getItemsData($items, bool $external = false): array
    {
        $data = [];
        foreach ($items as $item) {
            $itemData = [
                'Type' => $external ? 1 : 0,
                'Weight' => (float)$item->getWeight(),
                'Length' => $this->_config->getDVLength(),
                'Width' => $this->_config->getDVWidth(),
                'Height' => $this->_config->getDVHeight(),
            ];
            //additional fields for external shipments
            if ($external) {
                $itemData['code'] = $item->getId();
                $itemData['parcelContent'] = $item->getName();
            }

            $data[] = $itemData;
        }
        return $data;
    }

    /**
     * Method getCargusCounty
     *
     * @param int|null $regionId
     * @param string|null $region
     * @return CountyInterface|null
     */
    public function getCargusCounty(?int $regionId, ?string $region): ?CountyInterface
    {
        if ($regionId !== null && $region !== null) {
            $county = $this->_countyRepository->getByRegionId($regionId);
            if (!$county->getId()) {
                $county = $this->_countyRepository->getByName($this->_diacritics->remove($region));
            }

            if ($county->getId()) {
                return $county;
            }
        }
        return null;
    }

    /**
     * Method getCargusCity
     *
     * @param string $cityName
     * @param int $countyId
     * @return array|null
     */
    public function getCargusCity(string $cityName, int $countyId): ?array
    {
        if ($cityName !== '' && $countyId > 0) {
            $connection = $this->_resourceConnection->getConnection();
            $query = $connection->select()
                ->from(['UCC' => $this->_resourceConnection->getTableName(CityInterface::TABLE_NAME)])
                ->where('UCC.name = ?', $cityName)
                ->where('UCC.county_id = ?', $countyId);

            $city = $connection->fetchRow($query);
            if ($city !== false) {
                return $city;
            }
        }
        return null;
    }
}
