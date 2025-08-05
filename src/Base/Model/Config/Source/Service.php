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
 * Class Service
 *
 * Description class.
 */
class Service implements OptionSourceInterface
{
    public const STANDARD = 1;
    public const ECO_STANDARD = 34;
    public const MULTIPIECE = 39;

    /**
     * Method toOptionArray
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::STANDARD,
                'label' => __('Standard'),
            ],
            [
                'value' => self::ECO_STANDARD,
                'label' => __('Economic Standard'),
            ],
            [
                'value' => self::MULTIPIECE,
                'label' => __('Multipiece'),
            ],
        ];
    }
}
