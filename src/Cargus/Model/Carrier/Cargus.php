<?php

declare(strict_types=1);

namespace Urgent\Cargus\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Urgent\Base\Model\Api\ShippingCalculation;
use Urgent\Cargus\Model\UrgentCargus;
use Urgent\Base\Model\Helper\CurrencyConverter;

/**
 * Class Cargus
 *
 * Description class.
 */
class Cargus extends AbstractCarrier implements CarrierInterface
{
    /** @var string $_code */
    protected $_code = 'cargus';

    /** @var bool $_isFixed */
    protected $_isFixed = true;

    protected const RO_STORE_CURRENCY = 'RON';

    /** @var ResultFactory $_rateResultFactory */
    protected $_rateResultFactory;

    /** @var MethodFactory $_rateMethodFactory */
    protected $_rateMethodFactory;

    /** @var ShippingCalculation $_shippingCalculation */
    private ShippingCalculation $_shippingCalculation;

    /** @var StoreManagerInterface $storeManager */
    private StoreManagerInterface $storeManager;

    /** @var CurrencyConverter $currencyConverter */
    private CurrencyConverter $currencyConverter;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param ShippingCalculation  $shippingCalculation,
     * @param StoreManagerInterface $storeManager
     * @param CurrencyConverter $currencyConverter
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface  $scopeConfig,
        ErrorFactory          $rateErrorFactory,
        LoggerInterface       $logger,
        ResultFactory         $rateResultFactory,
        MethodFactory         $rateMethodFactory,
        ShippingCalculation   $shippingCalculation,
        StoreManagerInterface $storeManager,
        CurrencyConverter     $currencyConverter,
        array                 $data = []
    )
    {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_shippingCalculation = $shippingCalculation;
        $this->storeManager = $storeManager;
        $this->currencyConverter = $currencyConverter;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * Custom Shipping Rates Collector
     *
     * @param RateRequest $request
     * @return Result|bool
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        try {
            $storeCurrencyCode = $this->storeManager->getStore()->getCurrentCurrencyCode();
        } catch (\Exception $e) {
            $this->_logger->info('Shipping Calculation. No currency code found for store.' . $e->getMessage());
            return false;
        }

        $priceDynamic = (bool)$this->getConfigData('price_dynamic');

        if ($priceDynamic) {
            $shippingCalc = $this->_shippingCalculation->execute();

            if (empty($shippingCalc)) {
                return false;
            }

            if ($storeCurrencyCode !== $this::RO_STORE_CURRENCY) {
                if (isset($shippingCalc[0]['total'])) {
                    $shippingPrice = $shippingCalc[0]['total'];
                } else {
                    return false;
                }
            } elseif (isset($shippingCalc['GrandTotal'])) {
                $shippingPrice = (float)$shippingCalc['GrandTotal'];
            } else {
                return false;
            }
        } else {
            $shippingPrice = $this->getConfigData('price');
        }

        if ($this->getConfigData('ceiling_free_active')) {
            $minAmount = (float)$this->getConfigData('ceiling_min_amount');
            $grandTotal = 0;
            foreach ($request->getAllItems() as $item) {
                $grandTotal += $item->getRowTotal();
            }
            $shippingPrice = $grandTotal >= $minAmount ? 0 : $shippingPrice;
        }

        $result = $this->_rateResultFactory->create();

        if ($shippingPrice !== false) {
            $method = $this->_rateMethodFactory->create();

            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));

            $method->setMethod($this->_code);
            $method->setMethodTitle($this->getConfigData('name'));

//            if ($request->getFreeShipping() === true) {
//                $shippingPrice = '0.00';
//            }

            if ($storeCurrencyCode === $this::RO_STORE_CURRENCY) {
                $method->setPrice($shippingPrice);
                $method->setCost($shippingPrice);
            } else {
                //logic for skipping conversion, for shipping price from default store view to current one, for external shipments (dynamic price)
                try {
                    $backConversionRate = $this->currencyConverter->backConversionRate();
                } catch (LocalizedException $e) {
                    $this->_logger->info('No back conversion rate calculated.' . $e->getMessage());
                    return false;
                }
                if ($backConversionRate) {
                    $method->setPrice($shippingPrice * $backConversionRate);
                    $method->setCost($shippingPrice * $backConversionRate);
                } else {
                    return false;
                }
            }

            $result->append($method);
        }

        return $result;
    }

    /**
     * getAllowedMethods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}
