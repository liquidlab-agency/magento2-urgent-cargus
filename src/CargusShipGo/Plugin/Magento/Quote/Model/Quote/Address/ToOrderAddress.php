<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 03.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Plugin\Magento\Quote\Model\Quote\Address;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Psr\Log\LoggerInterface;
use Urgent\CargusShipGo\Model\Carrier\ShipAndGo;

/**
 * Class ToOrderAddress
 *
 * Description class.
 */
class ToOrderAddress
{
    /** @var LoggerInterface $logger */
    protected LoggerInterface $logger;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Method afterConvert
     *
     * @param \Magento\Quote\Model\Quote\Address\ToOrderAddress $subject
     * @param $result
     * @param $object
     * @param $data
     *
     * @return mixed
     */
    public function afterConvert(
        \Magento\Quote\Model\Quote\Address\ToOrderAddress $subject,
        $result,
        $object,
        $data = []
    ) {
        /** @var AddressInterface $object */
        /** @var OrderAddressInterface $result */
        if ($object->getShippingMethod() === ShipAndGo::CODE . '_' . ShipAndGo::CODE) {
            $pudoId = $object->getPudoId();
            $result->setPudoId($pudoId === null ? null : $pudoId);
        }
        return $result;
    }
}
