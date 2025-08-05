<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 01.02.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class ConsumerReturn
 *
 * Description: The options of consumer return config.
 */
class ConsumerReturn implements OptionSourceInterface
{
    public const CONSUMER_RETURN_NO = 0;
    public const CONSUMER_RETURN_CODE = 1;
    public const CONSUMER_RETURN_PRE_PRINT = 2;

    /**
     * Method toOptionArray
     *
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::CONSUMER_RETURN_NO, 'label' => __('No')],
            ['value' => self::CONSUMER_RETURN_CODE, 'label' => __('Return code')],
            ['value' => self::CONSUMER_RETURN_PRE_PRINT, 'label' => __('Preprint')],
        ];
    }
}
