<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 01.04.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Api\Data;

/**
 * Pudo Interface
 *
 * Description: Pudo Structure of object.
 */
interface PudoInterface
{
    public const TABLE = 'urgent_cargus_pudo';

    public const ID = 'id';
    public const PUDO_ID = 'pudo_id';
    public const SYMBOL = 'symbol';
    public const NAME = 'name';
    public const LOCATION_ID = 'location_id';
    public const COUNTY_ID = 'county_id';
    public const COUNTY = 'county';
    public const CITY_ID = 'city_id';
    public const CITY = 'city';
    public const STREET_ID = 'street_id';
    public const STREET_NAME = 'street_name';
    public const ZONE_ID = 'zone_id';
    public const POSTAL_CODE = 'postal_code';
    public const ENTRANCE = 'entrance';
    public const FLOOR = 'floor';
    public const APARTMENT = 'apartment';
    public const SECTOR = 'sector';
    public const ADDRESS = 'address';
    public const ADDRESS_DESCRIPTION = 'address_description';
    public const ADDITIONAL_ADDRESS_INFO = 'additional_address_info';
    public const LONGITUDE = 'longitude';
    public const LATITUDE = 'latitude';
    public const POINT_TYPE = 'point_type';
    public const OPEN_HOURS_MO_START = 'open_hours_mo_start';
    public const OPEN_HOURS_MO_END = 'open_hours_mo_end';
    public const OPEN_HOURS_TU_START = 'open_hours_tu_start';
    public const OPEN_HOURS_TU_END = 'open_hours_tu_end';
    public const OPEN_HOURS_WE_START = 'open_hours_we_start';
    public const OPEN_HOURS_WE_END = 'open_hours_we_end';
    public const OPEN_HOURS_TH_START = 'open_hours_th_start';
    public const OPEN_HOURS_TH_END = 'open_hours_th_end';
    public const OPEN_HOURS_FR_START = 'open_hours_fr_start';
    public const OPEN_HOURS_FR_END = 'open_hours_fr_end';
    public const OPEN_HOURS_SA_START = 'open_hours_sa_start';
    public const OPEN_HOURS_SA_END = 'open_hours_sa_end';
    public const OPEN_HOURS_SU_START = 'open_hours_su_start';
    public const OPEN_HOURS_SU_END = 'open_hours_su_end';
    public const STREET_NO = 'street_no';
    public const PHONE_NUMBER = 'phone_number';
    public const SERVICE_COD = 'service_cod';
    public const PAYMENT_TYPE = 'payment_type';
    public const EMAIL = 'email';
    public const ACCEPTED_PAYMENT_TYPE = 'accepted_payment_type';

    /**
     * Method getId
     *
     * @return int|null
     */
    public function getId();

    /**
     * Method setId
     *
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * Method getPudoId
     *
     * @return int
     */
    public function getPudoId(): int;

    /**
     * Method setPudoId
     *
     * @param int $pudoId
     * @return PudoInterface
     */
    public function setPudoId(int $pudoId): PudoInterface;

    /**
     * Method getSymbol
     *
     * @return string
     */
    public function getSymbol(): string;

    /**
     * Method setSymbol
     *
     * @param string $symbol
     * @return PudoInterface
     */
    public function setSymbol(string $symbol): PudoInterface;

    /**
     * Method getName
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Method setName
     *
     * @param string $name
     * @return PudoInterface
     */
    public function setName(string $name): PudoInterface;

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
     * @return PudoInterface
     */
    public function setLocationId(int $locationId): PudoInterface;

    /**
     * Method getCountyId
     *
     * @return int
     */
    public function getCountyId(): int;

    /**
     * Method setCountyId
     *
     * @param int $countyId
     * @return PudoInterface
     */
    public function setCountyId(int $countyId): PudoInterface;

    /**
     * Method getCounty
     *
     * @return string
     */
    public function getCounty(): string;

    /**
     * Method setCounty
     *
     * @param string $county
     * @return PudoInterface
     */
    public function setCounty(string $county): PudoInterface;

    /**
     * Method getCityId
     *
     * @return int
     */
    public function getCityId(): int;

    /**
     * Method setCityId
     *
     * @param int $cityId
     * @return PudoInterface
     */
    public function setCityId(int $cityId): PudoInterface;

    /**
     * Method getCity
     *
     * @return string
     */
    public function getCity(): string;

    /**
     * Method setCity
     *
     * @param string $city
     * @return PudoInterface
     */
    public function setCity(string $city): PudoInterface;

    /**
     * Method getStreetId
     *
     * @return int
     */
    public function getStreetId(): int;

    /**
     * Method setStreetId
     *
     * @param int $streetId
     * @return PudoInterface
     */
    public function setStreetId(int $streetId): PudoInterface;

    /**
     * Method getStreetName
     *
     * @return string
     */
    public function getStreetName(): string;

    /**
     * Method setStreetName
     *
     * @param string $streetName
     * @return PudoInterface
     */
    public function setStreetName(string $streetName): PudoInterface;

    /**
     * Method getZoneId
     *
     * @return int
     */
    public function getZoneId(): int;

    /**
     * Method setZoneId
     *
     * @param int $zoneId
     * @return PudoInterface
     */
    public function setZoneId(int $zoneId): PudoInterface;

    /**
     * Method getPostalCode
     *
     * @return string|null
     */
    public function getPostalCode(): ?string;

    /**
     * Method setPostalCode
     *
     * @param string|null $postalCode
     * @return PudoInterface
     */
    public function setPostalCode(?string $postalCode): PudoInterface;

    /**
     * Method getEntrance
     *
     * @return string|null
     */
    public function getEntrance(): ?string;

    /**
     * Method setEntrance
     *
     * @param string|null $entrance
     * @return PudoInterface
     */
    public function setEntrance(?string $entrance): PudoInterface;

    /**
     * Method getFloor
     *
     * @return string|null
     */
    public function getFloor(): ?string;

    /**
     * Method setFloor
     *
     * @param string|null $floor
     * @return PudoInterface
     */
    public function setFloor(?string $floor): PudoInterface;

    /**
     * Method getApartment
     *
     * @return string|null
     */
    public function getApartment(): ?string;

    /**
     * Method setApartment
     *
     * @param string|null $apartment
     * @return PudoInterface
     */
    public function setApartment(?string $apartment): PudoInterface;

    /**
     * Method getSector
     *
     * @return string|null
     */
    public function getSector(): ?string;

    /**
     * Method setSector
     *
     * @param string|null $sector
     * @return PudoInterface
     */
    public function setSector(?string $sector): PudoInterface;

    /**
     * Method getAddress
     *
     * @return string|null
     */
    public function getAddress(): ?string;

    /**
     * Method setAddress
     *
     * @param string|null $address
     * @return PudoInterface
     */
    public function setAddress(?string $address): PudoInterface;

    /**
     * Method getAddressDescription
     *
     * @return string|null
     */
    public function getAddressDescription(): ?string;

    /**
     * Method setAddressDescription
     *
     * @param string|null $addressDescription
     * @return PudoInterface
     */
    public function setAddressDescription(?string $addressDescription): PudoInterface;

    /**
     * Method getAdditionalAddressInfo
     *
     * @return string|null
     */
    public function getAdditionalAddressInfo(): ?string;

    /**
     * Method setAdditionalAddressInfo
     *
     * @param string|null $additionalAddressInfo
     * @return PudoInterface
     */
    public function setAdditionalAddressInfo(?string $additionalAddressInfo): PudoInterface;

    /**
     * Method getLongitude
     *
     * @return float
     */
    public function getLongitude(): float;

    /**
     * Method setLongitude
     *
     * @param float $longitude
     * @return PudoInterface
     */
    public function setLongitude(float $longitude): PudoInterface;

    /**
     * Method getLatitude
     *
     * @return float
     */
    public function getLatitude(): float;

    /**
     * Method setLatitude
     *
     * @param float $latitude
     * @return PudoInterface
     */
    public function setLatitude(float $latitude): PudoInterface;

    /**
     * Method getPointType
     *
     * @return int
     */
    public function getPointType(): int;

    /**
     * Method setPointType
     *
     * @param int $pointType
     * @return PudoInterface
     */
    public function setPointType(int $pointType): PudoInterface;

    /**
     * Method getOpenHoursMoStart
     *
     * @return string|null
     */
    public function getOpenHoursMoStart(): ?string;

    /**
     * Method setOpenHoursMoStart
     *
     * @param string|null $openHoursMoStart
     * @return PudoInterface
     */
    public function setOpenHoursMoStart(?string $openHoursMoStart): PudoInterface;

    /**
     * Method getOpenHoursMoEnd
     *
     * @return string|null
     */
    public function getOpenHoursMoEnd(): ?string;

    /**
     * Method setOpenHoursMoEnd
     *
     * @param string|null $openHoursMoEnd
     * @return PudoInterface
     */
    public function setOpenHoursMoEnd(?string $openHoursMoEnd): PudoInterface;

    /**
     * Method getOpenHoursTuStart
     *
     * @return string|null
     */
    public function getOpenHoursTuStart(): ?string;

    /**
     * Method setOpenHoursTuStart
     *
     * @param string|null $openHoursTuStart
     * @return PudoInterface
     */
    public function setOpenHoursTuStart(?string $openHoursTuStart): PudoInterface;

    /**
     * Method getOpenHoursTuEnd
     *
     * @return string|null
     */
    public function getOpenHoursTuEnd(): ?string;

    /**
     * Method setOpenHoursTuEnd
     *
     * @param string|null $openHoursTuEnd
     * @return PudoInterface
     */
    public function setOpenHoursTuEnd(?string $openHoursTuEnd): PudoInterface;

    /**
     * Method getOpenHoursWeStart
     *
     * @return string|null
     */
    public function getOpenHoursWeStart(): ?string;

    /**
     * Method getOpenHoursWeStart
     *
     * @param string|null $openHoursWeStart
     * @return PudoInterface
     */
    public function setOpenHoursWeStart(?string $openHoursWeStart): PudoInterface;

    /**
     * Method getOpenHoursWeEnd
     *
     * @return string|null
     */
    public function getOpenHoursWeEnd(): ?string;

    /**
     * Method setOpenHoursWeEnd
     *
     * @param string|null $openHoursWeEnd
     * @return PudoInterface
     */
    public function setOpenHoursWeEnd(?string $openHoursWeEnd): PudoInterface;

    /**
     * Method getOpenHoursThStart
     *
     * @return string|null
     */
    public function getOpenHoursThStart(): ?string;

    /**
     * Method setOpenHoursThStart
     *
     * @param string|null $openHoursThStart
     * @return PudoInterface
     */
    public function setOpenHoursThStart(?string $openHoursThStart): PudoInterface;

    /**
     * Method getOpenHoursThEnd
     *
     * @return string|null
     */
    public function getOpenHoursThEnd(): ?string;

    /**
     * Method setOpenHoursThEnd
     *
     * @param string|null $openHoursThEnd
     *
     * @return PudoInterface
     */
    public function setOpenHoursThEnd(?string $openHoursThEnd): PudoInterface;

    /**
     * Method getOpenHoursFrStart
     *
     * @return string|null
     */
    public function getOpenHoursFrStart(): ?string;

    /**
     * Method setOpenHoursFrStart
     *
     * @param string|null $openHoursFrStart
     * @return PudoInterface
     */
    public function setOpenHoursFrStart(?string $openHoursFrStart): PudoInterface;

    /**
     * Method getOpenHoursFrEnd
     *
     * @return string|null
     */
    public function getOpenHoursFrEnd(): ?string;

    /**
     * Method setOpenHoursFrEnd
     *
     * @param string|null $openHoursFrEnd
     *
     * @return PudoInterface
     */
    public function setOpenHoursFrEnd(?string $openHoursFrEnd): PudoInterface;

    /**
     * Method getOpenHoursSaStart
     *
     * @return string|null
     */
    public function getOpenHoursSaStart(): ?string;

    /**
     * Method setOpenHoursSaStart
     *
     * @param string|null $openHoursSaStart
     * @return PudoInterface
     */
    public function setOpenHoursSaStart(?string $openHoursSaStart): PudoInterface;

    /**
     * Method getOpenHoursSaEnd
     *
     * @return string|null
     */
    public function getOpenHoursSaEnd(): ?string;

    /**
     * Method setOpenHoursSaEnd
     *
     * @param string|null $openHoursSaEnd
     *
     * @return PudoInterface
     */
    public function setOpenHoursSaEnd(?string $openHoursSaEnd): PudoInterface;

    /**
     * Method getOpenHoursSuStart
     *
     * @return string|null
     */
    public function getOpenHoursSuStart(): ?string;

    /**
     * Method setOpenHoursSuStart
     *
     * @param string|null $openHoursSuStart
     * @return PudoInterface
     */
    public function setOpenHoursSuStart(?string $openHoursSuStart): PudoInterface;

    /**
     * Method getOpenHoursSuEnd
     *
     * @return string|null
     */
    public function getOpenHoursSuEnd(): ?string;

    /**
     * Method setOpenHoursSuEnd
     *
     * @param string|null $openHoursSuEnd
     *
     * @return PudoInterface
     */
    public function setOpenHoursSuEnd(?string $openHoursSuEnd): PudoInterface;

    /**
     * Method getStreetNo
     *
     * @return string|null
     */
    public function getStreetNo(): ?string;

    /**
     * Method setStreetNo
     *
     * @param string|null $streetNo
     * @return PudoInterface
     */
    public function setStreetNo(?string $streetNo): PudoInterface;

    /**
     * Method getPhoneNumber
     *
     * @return string|null
     */
    public function getPhoneNumber(): ?string;

    /**
     * Method setPhoneNumber
     *
     * @param string|null $phoneNumber
     * @return PudoInterface
     */
    public function setPhoneNumber(?string $phoneNumber): PudoInterface;

    /**
     * Method getServiceCod
     *
     * @return int
     */
    public function getServiceCod(): int;

    /**
     * Method setServiceCod
     *
     * @param int $serviceCod
     * @return PudoInterface
     */
    public function setServiceCod(int $serviceCod): PudoInterface;

    /**
     * Method getPaymentType
     *
     * @return int
     */
    public function getPaymentType(): int;

    /**
     * Method setPaymentType
     *
     * @param int $paymentType
     * @return PudoInterface
     */
    public function setPaymentType(int $paymentType): PudoInterface;

    /**
     * Method getEmail
     *
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * Method setEmail
     *
     * @param string|null $email
     * @return PudoInterface
     */
    public function setEmail(?string $email): PudoInterface;

    /**
     * Method getAcceptedPaymentType
     *
     * @return string|null
     */
    public function getAcceptedPaymentType(): ?string;

    /**
     * Method setAcceptedPaymentType
     *
     * @param string|null $acceptedPaymentType
     * @return PudoInterface
     */
    public function setAcceptedPaymentType(?string $acceptedPaymentType): PudoInterface;
}
