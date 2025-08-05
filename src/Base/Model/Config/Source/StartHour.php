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
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class StartHour
 *
 * Description class.
 */
class StartHour implements OptionSourceInterface
{
    /** @var TimezoneInterface $_timezone */
    protected TimezoneInterface $_timezone;

    /**
     * Constructor
     *
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        TimezoneInterface $timezone
    ) {
        $this->_timezone = $timezone;
    }

    /**
     * Method toOptionArray
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [];
        $currentDate = $this->_timezone->date();
        $currentDate->add(new \DateInterval('PT1H'));
        $startHour = $currentDate->format('H');
        for ($i = $startHour; $i <= 18; $i++) {
            $options[] = [
                'value' => $i,
                'label' => $i . ':00',
            ];
        }
        return $options;
    }
}
