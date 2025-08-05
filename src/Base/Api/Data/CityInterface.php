<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 09.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Api\Data;

/**
 * City Interface
 *
 * Description: City Cargus Structure of object.
 */
interface CityInterface
{
    public const TABLE_NAME = 'urgent_cargus_city';

    public const LOCALITY_ID = 'locality_id';
    public const NAME = 'name';
    public const PARENT_ID = 'parent_id';
    public const PARENT_NAME = 'parent_name';
    public const EXTRA_KM = 'extra_km';
    public const IN_NETWORK = 'in_network';
    public const COUNTY_ID = 'county_id';
    public const COUNTRY_ID = 'country_id';
    public const POSTAL_CODE = 'postal_code';
    public const MAX_HOUR = 'max_hour';
    public const SATURDAY_DELIVERY = 'saturday_delivery';

    /**
     * Method getId
     *
     * @return mixed
     */
    public function getId();

    /**
     * Method getName
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Method getParentId
     *
     * @return int
     */
    public function getParentId(): int;

    /**
     * Method getParentName
     *
     * @return string
     */
    public function getParentName(): string;

    /**
     * Method getExtraKm
     *
     * @return int
     */
    public function getExtraKm(): int;

    /**
     * Method getInNetwork
     *
     * @return bool
     */
    public function getInNetwork(): bool;

    /**
     * Method getCountyId
     *
     * @return int
     */
    public function getCountyId(): int;

    /**
     * Method getCountryId
     *
     * @return int
     */
    public function getCountryId(): int;

    /**
     * Method getPostalCode
     *
     * @return string
     */
    public function getPostalCode(): string;

    /**
     * Method getMaxHour
     *
     * @return string
     */
    public function getMaxHour(): string;

    /**
     * Method getSaturdayDelivery
     *
     * @return bool
     */
    public function getSaturdayDelivery(): bool;

    /**
     * Method setId
     *
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * Method setName
     *
     * @param string $name
     * @return CityInterface
     */
    public function setName(string $name): CityInterface;

    /**
     * Method setParentId
     *
     * @param int $parentId
     * @return CityInterface
     */
    public function setParentId(int $parentId): CityInterface;

    /**
     * Method setParentName
     *
     * @param string $parentName
     * @return CityInterface
     */
    public function setParentName(string $parentName): CityInterface;

    /**
     * Method setExtraKm
     *
     * @param int $extraKm
     * @return CityInterface
     */
    public function setExtraKm(int $extraKm): CityInterface;

    /**
     * Method setInNetwork
     *
     * @param bool $inNetwork
     * @return CityInterface
     */
    public function setInNetwork(bool $inNetwork): CityInterface;

    /**
     * Method setCountyId
     *
     * @param int $countyId
     * @return CityInterface
     */
    public function setCountyId(int $countyId): CityInterface;

    /**
     * Method setCountryId
     *
     * @param int $countryId
     * @return CityInterface
     */
    public function setCountryId(int $countryId): CityInterface;

    /**
     * Method setPostalCode
     *
     * @param string $postalCode
     * @return CityInterface
     */
    public function setPostalCode(string $postalCode): CityInterface;

    /**
     * Method setMaxHour
     *
     * @param string $maxHour
     * @return CityInterface
     */
    public function setMaxHour(string $maxHour): CityInterface;

    /**
     * Method setSaturdayDelivery
     *
     * @param bool $saturdayDelivery
     * @return CityInterface
     */
    public function setSaturdayDelivery(bool $saturdayDelivery): CityInterface;
}
