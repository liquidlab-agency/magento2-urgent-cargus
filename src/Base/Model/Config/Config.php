<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 *
 * Get all configs for cargus.
 */
class Config
{
    public const CONFIG_PATH_GENERAL = 'urgent_cargus';

    /** General Group */
    public const CONFIG_GENERAL = 'general';
    public const GENERAL_LIFTING_POINT = 'lifting_point';
    public const GENERAL_PACKAGE_OPENING = 'package_opening';
    public const GENERAL_INSURANCE = 'insurance';
    public const GENERAL_SATURDAY_DELIVERY = 'saturday_delivery';
    public const GENERAL_MORNING_DELIVERY = 'morning_delivery';
    public const GENERAL_REPAYMENT = 'repayment';
    public const GENERAL_PAYER = 'payer';
    public const GENERAL_DEFAULT_SHIPMENT_TYPE = 'default_shipment_type';
    public const GENERAL_SERVICE = 'service';
    public const GENERAL_PRICE_TABLE = 'price_table';
    public const GENERAL_CONSUMER_RETURN = 'consumer_return';
    public const GENERAL_CONSUMER_RETURN_DAYS = 'consumer_return_days';
    public const GENERAL_AWB_FORMAT = 'awb_format';

    /** Location */
    public const CONFIG_LOCATION = 'location';
    public const LOCATION_COUNTY = 'county';
    public const LOCATION_CITY = 'city';

    /** Default Values */
    public const CONFIG_DEFAULT_VALUES = 'default_values';
    public const DV_LENGTH = 'length';
    public const DV_WIDTH = 'width';
    public const DV_HEIGHT = 'height';
    public const DV_WEIGHT = 'weight';

    /** Api Group */
    public const CONFIG_API = 'api';
    public const API_ACTIVE = 'active';
    public const API_URL = 'url';
    public const API_URL_V4 = 'url_v4';
    public const API_KEY = 'key';
    public const API_USERNAME = 'username';
    public const API_PASSWORD = 'password';
    public const API_TIMEOUT = 'timeout';

    /** Debug Group */
    public const CONFIG_DEBUG = 'debug';
    public const DEBUG_LOGGER = 'logger';

    public const CONFIG_PATH_NOMENCLATURE = 'urgent_cargus_nomenclature';
    public const NOMENCLATURE_UPDATE = 'nomenclature_update';
    public const NOMENCLATURE_SPECIFIC_COUNTRY = 'specific_country';

    /** @var ScopeConfigInterface $_scopeConfig */
    private ScopeConfigInterface $_scopeConfig;
    /** @var array $_configs */
    private $_configs;
    /** @var array $_configsNomenclature */
    private $_configsNomenclature;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_configs = $this->_scopeConfig->getValue(self::CONFIG_PATH_GENERAL);
        $this->_configsNomenclature = $this->_scopeConfig->getValue(self::CONFIG_PATH_NOMENCLATURE);
    }

    /**
     * Method getGeneral
     *
     * @return array
     */
    public function getGeneral(): array
    {
        return $this->_configs[self::CONFIG_GENERAL] ?? [];
    }

    /**
     * Method getGeneralLiftingPoint
     *
     * @return int|null
     */
    public function getGeneralLiftingPoint(): ?int
    {
        $general = $this->getGeneral();
        return isset($general[self::GENERAL_LIFTING_POINT]) ? (int)$general[self::GENERAL_LIFTING_POINT] : null;
    }

    /**
     * Method getGeneralPackageOpening
     *
     * @return bool
     */
    public function getGeneralPackageOpening(): bool
    {
        $general = $this->getGeneral();
        return isset($general[self::GENERAL_PACKAGE_OPENING]) && (bool)$general[self::GENERAL_PACKAGE_OPENING];
    }

    /**
     * Method getGeneralInsurance
     *
     * @return bool
     */
    public function getGeneralInsurance(): bool
    {
        $general = $this->getGeneral();
        return isset($general[self::GENERAL_INSURANCE]) && (bool)$general[self::GENERAL_INSURANCE];
    }

    /**
     * Method getGeneralSaturdayDelivery
     *
     * @return bool
     */
    public function getGeneralSaturdayDelivery(): bool
    {
        $general = $this->getGeneral();
        return isset($general[self::GENERAL_SATURDAY_DELIVERY]) && (bool)$general[self::GENERAL_SATURDAY_DELIVERY];
    }

    /**
     * Method getGeneralMorningDelivery
     *
     * @return bool
     */
    public function getGeneralMorningDelivery(): bool
    {
        $general = $this->getGeneral();
        return isset($general[self::GENERAL_MORNING_DELIVERY]) && (bool)$general[self::GENERAL_MORNING_DELIVERY];
    }

    /**
     * Method getGeneralRepayment
     *
     * @return int
     */
    public function getGeneralRepayment(): int
    {
        $general = $this->getGeneral();
        return (int)$general[self::GENERAL_REPAYMENT];
    }

    /**
     * Method getGeneralPayer
     *
     * @return int
     */
    public function getGeneralPayer(): int
    {
        $general = $this->getGeneral();
        return (int)$general[self::GENERAL_PAYER];
    }

    /**
     * Method getGeneralDefaultShipmentType
     *
     * @return int
     */
    public function getGeneralDefaultShipmentType(): int
    {
        $general = $this->getGeneral();
        return (int)$general[self::GENERAL_DEFAULT_SHIPMENT_TYPE];
    }

    /**
     * Method getGeneralService
     *
     * @return int
     */
    public function getGeneralService(): int
    {
        $general = $this->getGeneral();
        return (int)$general[self::GENERAL_SERVICE];
    }

    /**
     *  Method getGeneralPriceTable by store
     *
     * @param $storeId
     */
    public function getGeneralPriceTable($storeId = null)
    {
        return $this->_scopeConfig->getValue(
            $this::CONFIG_PATH_GENERAL . '/' . $this::CONFIG_GENERAL . '/' . $this::GENERAL_PRICE_TABLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Method getGeneralConsumerReturn
     *
     * @return int
     */
    public function getGeneralConsumerReturn(): int
    {
        $general = $this->getGeneral();
        return (int)$general[self::GENERAL_CONSUMER_RETURN];
    }

    /**
     * Method getGeneralConsumerReturnDays
     *
     * @return int
     */
    public function getGeneralConsumerReturnDays(): int
    {
        $general = $this->getGeneral();
        return (int)$general[self::GENERAL_CONSUMER_RETURN_DAYS];
    }

    /**
     * Method getGeneralAwbFormat
     *
     * @return int
     */
    public function getGeneralAwbFormat(): int
    {
        $general = $this->getGeneral();
        return isset($general[self::GENERAL_AWB_FORMAT]) ? (int)$general[self::GENERAL_AWB_FORMAT] : 0;
    }

    /**
     * Method getLocation
     *
     * @return array
     */
    public function getLocation(): array
    {
        return $this->_configs[self::CONFIG_LOCATION] ?? [];
    }

    /**
     * Method getLocationCounty
     *
     * @return int
     */
    public function getLocationCounty(): int
    {
        $location = $this->getLocation();
        return isset($location[self::LOCATION_COUNTY]) ? (int)$location[self::LOCATION_COUNTY] : 0;
    }

    /**
     * Method getLocationCity
     *
     * @return int
     */
    public function getLocationCity(): int
    {
        $location = $this->getLocation();
        return isset($location[self::LOCATION_CITY]) ? (int)$location[self::LOCATION_CITY] : 0;
    }

    /**
     * Method getDefaultValues
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        return $this->_configs[self::CONFIG_DEFAULT_VALUES] ?? [];
    }

    /**
     * Method getDVLength
     *
     * @return int
     */
    public function getDVLength(): int
    {
        $dv = $this->getDefaultValues();
        return isset($dv[self::DV_LENGTH]) ? (int)$dv[self::DV_LENGTH] : 0;
    }

    /**
     * Method getDVWidth
     *
     * @return int
     */
    public function getDVWidth(): int
    {
        $dv = $this->getDefaultValues();
        return isset($dv[self::DV_WIDTH]) ? (int)$dv[self::DV_WIDTH] : 0;
    }

    /**
     * Method getDVHeight
     *
     * @return int
     */
    public function getDVHeight(): int
    {
        $dv = $this->getDefaultValues();
        return isset($dv[self::DV_HEIGHT]) ? (int)$dv[self::DV_HEIGHT] : 0;
    }

    /**
     * Method getDVWeight
     *
     * @return int
     */
    public function getDVWeight(): int
    {
        $dv = $this->getDefaultValues();
        return isset($dv[self::DV_WEIGHT]) ? (int)$dv[self::DV_WEIGHT] : 0;
    }

    /**
     * Method getApi
     *
     * @return array
     */
    public function getApi(): array
    {
        return $this->_configs[self::CONFIG_API] ?? [];
    }

    /**
     * Method getApiIsActive
     *
     * @return bool
     */
    public function getApiIsActive(): bool
    {
        $api = $this->getApi();
        return isset($api[self::API_ACTIVE]) && (bool)$api[self::API_ACTIVE];
    }

    /**
     * Method getApiUrl
     *
     * @return string
     */
    public function getApiUrl(): string
    {
        $api = $this->getApi();
        return $api[self::API_URL] ?? '';
    }

    /**
     * Method getApiUrlV4
     *
     * @return string
     */
    public function getApiUrlV4(): string
    {
        $api = $this->getApi();
        return $api[self::API_URL_V4] ?? '';
    }

    /**
     * Method getApiKey
     *
     * @return string
     */
    public function getApiKey(): string
    {
        $api = $this->getApi();
        return $api[self::API_KEY] ?? '';
    }

    /**
     * Method getApiUsername
     *
     * @return string
     */
    public function getApiUsername(): string
    {
        $api = $this->getApi();
        return $api[self::API_USERNAME] ?? '';
    }

    /**
     * Method getApiPassword
     *
     * @return string
     */
    public function getApiPassword(): string
    {
        $api = $this->getApi();
        return $api[self::API_PASSWORD] ?? '';
    }

    /**
     * Method getApiTimeout
     *
     * @return int
     */
    public function getApiTimeout(): int
    {
        $api = $this->getApi();
        return isset($api[self::API_TIMEOUT]) && $api[self::API_TIMEOUT] > 0 ? (int)$api[self::API_TIMEOUT] : 10;
    }

    /**
     * Method getDebug
     *
     * @return array
     */
    public function getDebug(): array
    {
        return $this->_configs[self::CONFIG_DEBUG] ?? [];
    }

    /**
     * Method getDebugLogger
     *
     * @return bool
     */
    public function getDebugLogger(): bool
    {
        $debug = $this->getDebug();
        return isset($debug[self::DEBUG_LOGGER]) && (bool)$debug[self::DEBUG_LOGGER];
    }

    /**
     * Method getNomenclature
     *
     * @return array
     */
    public function getNomenclatureUpdate(): array
    {
        return $this->_configsNomenclature[self::NOMENCLATURE_UPDATE] ?? [];
    }

    /**
     * Method getNomenclatureSpecificCountry
     *
     * @return string
     */
    public function getNomenclatureSpecificCountry(): string
    {
        $nomenclatureConfig = $this->getNomenclatureUpdate();
        return $nomenclatureConfig[self::NOMENCLATURE_SPECIFIC_COUNTRY] ?? '';
    }
}
