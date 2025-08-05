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
 * Class LiftingPoint
 *
 * Description class.
 */
class LiftingPoint implements OptionSourceInterface
{
    private \Urgent\Base\Model\Api\LiftingPoint $_liftingPoint;

    /**
     * @param \Urgent\Base\Model\Api\LiftingPoint $liftingPoint
     */
    public function __construct(\Urgent\Base\Model\Api\LiftingPoint $liftingPoint)
    {
        $this->_liftingPoint = $liftingPoint;
    }

    /**
     * Method toOptionArray
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $pickupLocations = $this->_liftingPoint->execute();
        $options = [];
        if (count($pickupLocations)) {
            foreach ($pickupLocations as $location) {
                $options[] = [
                    'value' => $location['LocationId'],
                    'label' => $location['Name'],
                ];
            }
        }
        return $options;
    }
}
