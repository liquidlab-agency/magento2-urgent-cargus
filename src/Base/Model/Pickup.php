<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 29.06.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Urgent\Base\Api\Data\PickupInterface;

/**
 * Class Pickup
 *
 * Description: ...
 */
class Pickup extends AbstractModel implements PickupInterface, IdentityInterface
{
    protected $_cacheTag = PickupInterface::TABLE_NAME;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Pickup::class);
    }

    /**
     * Method getIdentities
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [PickupInterface::TABLE_NAME . '_' . $this->getId()];
    }

    /**
     * Method getId
     *
     * @return array|mixed|null
     */
    public function getId()
    {
        return $this->getData(PickupInterface::ID);
    }

    /**
     * Method getLocationId
     *
     * @return int
     */
    public function getLocationId(): int
    {
        return (int)$this->getData(PickupInterface::LOCATION_ID);
    }

    /**
     * Method getStartDate
     *
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->getData(PickupInterface::START_DATE);
    }

    /**
     * Method getEndDate
     *
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->getData(PickupInterface::END_DATE);
    }

    /**
     * Method getStatus
     *
     * @return int
     */
    public function getStatus(): int
    {
        return (int)$this->getData(PickupInterface::STATUS);
    }

    /**
     * Method setId
     *
     * @param $id
     * @return Pickup
     */
    public function setId($id)
    {
        return $this->setData(PickupInterface::ID, $id);
    }

    /**
     * Method setLocationId
     *
     * @param int $locationId
     * @return PickupInterface
     */
    public function setLocationId(int $locationId): PickupInterface
    {
        return $this->setData(PickupInterface::LOCATION_ID, $locationId);
    }

    /**
     * Method setStartDate
     *
     * @param string $startDate
     * @return PickupInterface
     */
    public function setStartDate(string $startDate): PickupInterface
    {
        return $this->setData(PickupInterface::START_DATE, $startDate);
    }

    /**
     * Method setEndDate
     *
     * @param string $endDate
     * @return PickupInterface
     */
    public function setEndDate(string $endDate): PickupInterface
    {
        return $this->setData(PickupInterface::END_DATE, $endDate);
    }

    /**
     * Method setStatus
     *
     * @param int $status
     * @return PickupInterface
     */
    public function setStatus(int $status): PickupInterface
    {
        return $this->setData(PickupInterface::STATUS, $status);
    }
}
