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
 * County Interface
 *
 * Description: County Cargus Structure of object.
 */
interface CountyInterface
{
    public const TABLE_NAME = 'urgent_cargus_county';

    public const COUNTY_ID = 'county_id';
    public const NAME = 'name';
    public const ABBREVIATION = 'abbreviation';
    public const COUNTRY_ID = 'country_id';
    public const REGION_ID = 'region_id';

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
     * Method getAbbreviation
     *
     * @return string
     */
    public function getAbbreviation(): string;

    /**
     * Method getCountryId
     *
     * @return int
     */
    public function getCountryId(): int;

    /**
     * Method getRegionId
     *
     * @return int|null
     */
    public function getRegionId(): ?int;

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
     * @return CountyInterface
     */
    public function setName(string $name): CountyInterface;

    /**
     * Method setAbbreviation
     *
     * @param string $abbreviation
     * @return CountyInterface
     */
    public function setAbbreviation(string $abbreviation): CountyInterface;

    /**
     * Method setCountryId
     *
     * @param int $countryId
     * @return CountyInterface
     */
    public function setCountryId(int $countryId): CountyInterface;

    /**
     * Method setRegionId
     *
     * @param int|null $regionId
     * @return CountyInterface
     */
    public function setRegionId(?int $regionId = 0): CountyInterface;
}
