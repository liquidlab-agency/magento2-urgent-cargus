<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 03.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Plugin\Frontend\Magento\Checkout\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Framework\Exception\InputException;
use Urgent\CargusShipGo\Model\Carrier\ShipAndGo;

/**
 * Class ShippingInformationManagement
 *
 * Description class.
 */
class ShippingInformationManagement
{
    /**
     * Method beforeSaveAddressInformation
     *
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param $addressInformation
     *
     * @return array
     * @throws InputException
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        $addressInformation
    ) {
        /** @var ShippingInformationInterface $addressInformation */
        if ($addressInformation->getShippingMethodCode() === ShipAndGo::CODE) {
            $extensionAttr = $addressInformation->getExtensionAttributes();
            if ($extensionAttr->getPudoId() > 0) {
                $address = $addressInformation->getShippingAddress();
                $address->setPudoId($extensionAttr->getPudoId());
            }
        } else {
            $address = $addressInformation->getShippingAddress();
            $address->setPudoId(null);
        }
        return [$cartId, $addressInformation];
    }
}
