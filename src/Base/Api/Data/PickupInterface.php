<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Api\Data;

/**
 * Pickup Interface
 *
 * Description: Pickup truck for the awb that are created.
 */
interface PickupInterface
{
    public const TABLE_NAME = 'urgent_cargus_pickup';

    public const ID = 'id';
    public const LOCATION_ID = 'location_id';
    public const START_DATE = 'start_date';
    public const END_DATE = 'end_date';
    public const STATUS = 'status';

    public const STATUS_ACTION_SUBMIT = 1;
    public const STATUS_ACTION_CANCEL = 0;

    /**
     * Method getId
     *
     * @return mixed
     */
    public function getId();

    /**
     * Method getLocationId
     *
     * @return int
     */
    public function getLocationId(): int;

    /**
     * Method setLocationId
     *
     * @param int $locationId
     * @return PickupInterface
     */
    public function setLocationId(int $locationId): PickupInterface;

    /**
     * Method getStartDate
     *
     * @return string
     */
    public function getStartDate(): string;

    /**
     * Method setStartDate
     *
     * @param string $startDate
     * @return PickupInterface
     */
    public function setStartDate(string $startDate): PickupInterface;

    /**
     * Method getEndDate
     *
     * @return string
     */
    public function getEndDate(): string;

    /**
     * Method setEndDate
     *
     * @param string $endDate
     * @return PickupInterface
     */
    public function setEndDate(string $endDate): PickupInterface;

    /**
     * Method getStatus
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Method setStatus
     *
     * @param int $status
     * @return PickupInterface
     */
    public function setStatus(int $status): PickupInterface;
}
