<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 17.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Repayment
 *
 * Description class.
 */
class Repayment implements OptionSourceInterface
{
    /**
     * Method toOptionArray
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => 0,
                'label' => __('Cash'),
            ],
            [
                'value' => 1,
                'label' => __('Account Collecting'),
            ],
        ];
    }
}
