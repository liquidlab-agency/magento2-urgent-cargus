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
 * Class Payer
 *
 * Description class.
 */
class Payer implements OptionSourceInterface
{
    public const SENDER = 1;
    public const CONSIGNEE = 2;
    /**
     * Method toOptionArray
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::SENDER,
                'label' => __('Sender'),
            ],
            [
                'value' => self::CONSIGNEE,
                'label' => __('Consignee'),
            ],
        ];
    }
}
