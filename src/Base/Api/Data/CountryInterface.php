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
 * Country Interface
 *
 * Description: Country Cargus Structure of object.
 */
interface CountryInterface
{
    public const TABLE_NAME = 'urgent_cargus_country';

    public const COUNTRY_ID = 'country_id';
    public const COUNTRY_NAME = 'country_name';
    public const ABBREVIATION = 'abbreviation';

    /**
     * Method getId
     *
     * @return mixed
     */
    public function getId();

    /**
     * Method getCountryName
     *
     * @return string
     */
    public function getCountryName(): string;

    /**
     * Method getAbbreviation
     *
     * @return string
     */
    public function getAbbreviation(): string;

    /**
     * Method setId
     *
     * @param $id
     *
     * @return mixed
     */
    public function setId($id);

    /**
     * Method setCountryName
     *
     * @param string $countryName
     * @return CountryInterface
     */
    public function setCountryName(string $countryName): CountryInterface;

    /**
     * Method setAbbreviation
     *
     * @param string $abbreviation
     * @return CountryInterface
     */
    public function setAbbreviation(string $abbreviation): CountryInterface;
}
