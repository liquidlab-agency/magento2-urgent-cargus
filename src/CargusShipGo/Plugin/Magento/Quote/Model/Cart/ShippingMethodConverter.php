<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 26.04.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Plugin\Magento\Quote\Model\Cart;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Api\Data\ShippingMethodExtensionFactory;
use Magento\Store\Model\ScopeInterface;

/**
 * Class ShippingMethodConverter
 *
 * Description class.
 */
class ShippingMethodConverter
{
    /** @var ShippingMethodExtensionFactory $_extensionFactory */
    protected ShippingMethodExtensionFactory $_extensionFactory;
    /** @var ScopeConfigInterface $_scopeConfig */
    protected ScopeConfigInterface $_scopeConfig;

    /**
     * Constructor
     *
     * @param ShippingMethodExtensionFactory $extensionFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ShippingMethodExtensionFactory $extensionFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_extensionFactory = $extensionFactory;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * Method afterModelToDataObject
     *
     * @param \Magento\Quote\Model\Cart\ShippingMethodConverter $subject
     * @param $result
     * @param $rateModel
     * @param $quoteCurrencyCode
     *
     * @return mixed
     */
    public function afterModelToDataObject(
        \Magento\Quote\Model\Cart\ShippingMethodConverter $subject,
        $result,
        $rateModel,
        $quoteCurrencyCode
    ) {
        $extensionAttribute = $this->_extensionFactory->create();
        if ($result->getExtensionAttributes()) {
            $extensionAttribute = $result->getExtensionAttributes();
        }
        $extensionAttribute->setHasMap($this->hasMap($result->getMethodCode()));
        return $result;
    }

    /**
     * Method hasMap
     *
     * @param string $code
     *
     * @return bool
     */
    private function hasMap(string $code): bool
    {
        $path = 'carriers/' . $code . '/has_map';
        return (bool)$this->_scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }
}
