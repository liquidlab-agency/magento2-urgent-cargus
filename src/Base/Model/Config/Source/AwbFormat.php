<?php
/**
 * User: Alexandru Manuel Carabus
 * Date: 14.10.2025
 * Copyright: Liquidlab
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class AwbFormat
 *
 * Description: The options of AWB format for printing.
 */
class AwbFormat implements OptionSourceInterface
{
    public const FORMAT_A4 = 0;
    public const FORMAT_A6 = 1;

    /**
     * Method toOptionArray
     *
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::FORMAT_A4, 'label' => __('A4')],
            ['value' => self::FORMAT_A6, 'label' => __('A6')],
        ];
    }
}
