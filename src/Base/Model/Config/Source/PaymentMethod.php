<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 24.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Payment\Helper\Data;

/**
 * Class PaymentMethod
 *
 * Description: Get all payment method for system config list.
 */
class PaymentMethod implements OptionSourceInterface
{
    /** @var Data $_paymentHelper */
    protected Data $_paymentHelper;

    /**
     * Constructor
     *
     * @param Data $paymentHelper
     */
    public function __construct(
        Data $paymentHelper
    ) {
        $this->_paymentHelper = $paymentHelper;
    }

    /**
     * Method toOptionArray
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $paymentMethods = $this->_paymentHelper->getPaymentMethods();
        if (count($paymentMethods)) {
            $result = [];
            foreach ($paymentMethods as $paymentCode => $paymentMethod) {
                if (!isset($paymentMethod['title'])) {
                    continue;
                }
                $result[] = [
                    'value' => $paymentCode,
                    'label' => $paymentMethod['title']
                ];
            }
            return $result;
        }
        return [];
    }
}
