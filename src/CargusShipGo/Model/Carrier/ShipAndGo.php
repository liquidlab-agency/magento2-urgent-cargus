<?php
declare(strict_types=1);
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 09.03.2022
 * Copyright: Tremend Software Consulting
 */

namespace Urgent\CargusShipGo\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;

/**
 * Class ShipAndGo
 *
 * Description class.
 */
class ShipAndGo extends AbstractCarrier implements CarrierInterface
{
    public const CODE = 'cargus_shipandgo';

    protected $_code = self::CODE;

    protected $_isFixed = true;

    protected $_rateResultFactory;

    protected $_rateMethodFactory;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory         $rateErrorFactory,
        LoggerInterface      $logger,
        ResultFactory        $rateResultFactory,
        MethodFactory        $rateMethodFactory,
        array                $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $shippingPrice = $this->getConfigData('price');

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
            
            $method->setPrice($shippingPrice);
            $method->setCost($shippingPrice);

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
