<?php

namespace Urgent\Base\Ui\Component\Pickup\Listing\Column\Status;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Options for Listing Column Status
 */
class Options implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return[
            [
                'value' => '1',
                'label' => __('Ordered')
            ],
            [
                'value' => '0',
                'label' => __('Canceled')
            ]
        ];
    }
}
