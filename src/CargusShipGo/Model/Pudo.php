<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 01.04.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Urgent\CargusShipGo\Api\Data\PudoInterface;

/**
 * Class Pudo
 *
 * Description class.
 */
class Pudo extends AbstractModel implements PudoInterface, IdentityInterface
{
    protected const CACHE_TAG = 'urgent_cargus_pudo';

    /** @var string $_cacheTag */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Pudo::class);
    }

    /**
     * Method getIdentities
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Method getId
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(PudoInterface::ID);
    }

    /**
     * Method setId
     *
     * @param $id
     * @return PudoInterface|Pudo
     */
    public function setId($id)
    {
        return $this->setData(PudoInterface::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getPudoId(): int
    {
        return (int)$this->getData(PudoInterface::PUDO_ID);
    }

    /**
     * @inheritDoc
     */
    public function setPudoId(int $pudoId): PudoInterface
    {
        return $this->setData(PudoInterface::PUDO_ID, $pudoId);
    }

    /**
     * @inheritDoc
     */
    public function getSymbol(): string
    {
        return $this->getData(PudoInterface::SYMBOL);
    }

    /**
     * @inheritDoc
     */
    public function setSymbol(string $symbol): PudoInterface
    {
        return $this->setData(PudoInterface::SYMBOL, $symbol);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->getData(PudoInterface::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): PudoInterface
    {
        return $this->setData(PudoInterface::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getLocationId(): int
    {
        return (int)$this->getData(PudoInterface::LOCATION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLocationId(int $locationId): PudoInterface
    {
        return $this->setData(PudoInterface::LOCATION_ID, $locationId);
    }

    /**
     * @inheritDoc
     */
    public function getCountyId(): int
    {
        return (int)$this->getData(PudoInterface::COUNTY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCountyId(int $countyId): PudoInterface
    {
        return $this->setData(PudoInterface::COUNTY_ID, $countyId);
    }

    /**
     * @inheritDoc
     */
    public function getCounty(): string
    {
        return $this->getData(PudoInterface::COUNTY);
    }

    /**
     * @inheritDoc
     */
    public function setCounty(string $county): PudoInterface
    {
        return $this->setData(PudoInterface::COUNTY, $county);
    }

    /**
     * @inheritDoc
     */
    public function getCityId(): int
    {
        return (int)$this->getData(PudoInterface::CITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCityId(int $cityId): PudoInterface
    {
        return $this->setData(PudoInterface::CITY_ID, $cityId);
    }

    /**
     * @inheritDoc
     */
    public function getCity(): string
    {
        return $this->getData(PudoInterface::CITY);
    }

    /**
     * @inheritDoc
     */
    public function setCity(string $city): PudoInterface
    {
        return $this->setData(PudoInterface::CITY, $city);
    }

    /**
     * @inheritDoc
     */
    public function getStreetId(): int
    {
        return (int)$this->getData(PudoInterface::STREET_ID);
    }

    /**
     * @inheritDoc
     */
    public function setStreetId(int $streetId): PudoInterface
    {
        return $this->setData(PudoInterface::STREET_ID, $streetId);
    }

    /**
     * @inheritDoc
     */
    public function getStreetName(): string
    {
        return $this->getData(PudoInterface::STREET_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setStreetName(string $streetName): PudoInterface
    {
        return $this->setData(PudoInterface::STREET_NAME, $streetName);
    }

    /**
     * @inheritDoc
     */
    public function getZoneId(): int
    {
        return (int)$this->getData(PudoInterface::ZONE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setZoneId(int $zoneId): PudoInterface
    {
        return $this->setData(PudoInterface::ZONE_ID, $zoneId);
    }

    /**
     * @inheritDoc
     */
    public function getPostalCode(): ?string
    {
        return $this->getData(PudoInterface::POSTAL_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setPostalCode(?string $postalCode): PudoInterface
    {
        return $this->setData(PudoInterface::POSTAL_CODE, $postalCode);
    }

    /**
     * @inheritDoc
     */
    public function getEntrance(): ?string
    {
        return $this->getData(PudoInterface::ENTRANCE);
    }

    /**
     * @inheritDoc
     */
    public function setEntrance(?string $entrance): PudoInterface
    {
        return $this->setData(PudoInterface::ENTRANCE, $entrance);
    }

    /**
     * @inheritDoc
     */
    public function getFloor(): ?string
    {
        return $this->getData(PudoInterface::FLOOR);
    }

    /**
     * @inheritDoc
     */
    public function setFloor(?string $floor): PudoInterface
    {
        return $this->setData(PudoInterface::FLOOR, $floor);
    }

    /**
     * @inheritDoc
     */
    public function getApartment(): ?string
    {
        return $this->getData(PudoInterface::APARTMENT);
    }

    /**
     * @inheritDoc
     */
    public function setApartment(?string $apartment): PudoInterface
    {
        return $this->setData(PudoInterface::APARTMENT, $apartment);
    }

    /**
     * @inheritDoc
     */
    public function getSector(): ?string
    {
        return $this->getData(PudoInterface::SECTOR);
    }

    /**
     * @inheritDoc
     */
    public function setSector(?string $sector): PudoInterface
    {
        return $this->setData(PudoInterface::SECTOR, $sector);
    }

    /**
     * @inheritDoc
     */
    public function getAddress(): ?string
    {
        return $this->getData(PudoInterface::ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setAddress(?string $address): PudoInterface
    {
        return $this->setData(PudoInterface::ADDRESS, $address);
    }

    /**
     * @inheritDoc
     */
    public function getAddressDescription(): ?string
    {
        return $this->getData(PudoInterface::ADDRESS_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setAddressDescription(?string $addressDescription): PudoInterface
    {
        return $this->setData(PudoInterface::ADDRESS_DESCRIPTION, $addressDescription);
    }

    /**
     * @inheritDoc
     */
    public function getAdditionalAddressInfo(): ?string
    {
        return $this->getData(PudoInterface::ADDITIONAL_ADDRESS_INFO);
    }

    /**
     * @inheritDoc
     */
    public function setAdditionalAddressInfo(?string $additionalAddressInfo): PudoInterface
    {
        return $this->setData(PudoInterface::ADDITIONAL_ADDRESS_INFO, $additionalAddressInfo);
    }

    /**
     * @inheritDoc
     */
    public function getLongitude(): float
    {
        return (float)$this->getData(PudoInterface::LONGITUDE);
    }

    /**
     * @inheritDoc
     */
    public function setLongitude(float $longitude): PudoInterface
    {
        return $this->setData(PudoInterface::LONGITUDE, $longitude);
    }

    /**
     * @inheritDoc
     */
    public function getLatitude(): float
    {
        return (float)$this->getData(PudoInterface::LATITUDE);
    }

    /**
     * @inheritDoc
     */
    public function setLatitude(float $latitude): PudoInterface
    {
        return $this->setData(PudoInterface::LATITUDE, $latitude);
    }

    /**
     * @inheritDoc
     */
    public function getPointType(): int
    {
        return (int)$this->getData(PudoInterface::POINT_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setPointType(int $pointType): PudoInterface
    {
        return $this->setData(PudoInterface::POINT_TYPE, $pointType);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursMoStart(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_MO_START);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursMoStart(?string $openHoursMoStart): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_MO_START, $openHoursMoStart);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursMoEnd(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_MO_END);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursMoEnd(?string $openHoursMoEnd): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_MO_END, $openHoursMoEnd);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursTuStart(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_TU_START);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursTuStart(?string $openHoursTuStart): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_TU_START, $openHoursTuStart);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursTuEnd(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_TU_END);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursTuEnd(?string $openHoursTuEnd): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_TU_END, $openHoursTuEnd);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursWeStart(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_WE_START);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursWeStart(?string $openHoursWeStart): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_WE_START, $openHoursWeStart);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursWeEnd(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_WE_END);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursWeEnd(?string $openHoursWeEnd): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_WE_END, $openHoursWeEnd);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursThStart(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_TH_START);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursThStart(?string $openHoursThStart): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_TH_START, $openHoursThStart);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursThEnd(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_TH_END);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursThEnd(?string $openHoursThEnd): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_TH_END, $openHoursThEnd);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursFrStart(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_FR_START);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursFrStart(?string $openHoursFrStart): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_FR_START, $openHoursFrStart);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursFrEnd(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_FR_END);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursFrEnd(?string $openHoursFrEnd): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_FR_END, $openHoursFrEnd);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursSaStart(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_SA_START);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursSaStart(?string $openHoursSaStart): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_SA_START, $openHoursSaStart);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursSaEnd(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_SA_END);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursSaEnd(?string $openHoursSaEnd): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_SA_END, $openHoursSaEnd);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursSuStart(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_SU_START);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursSuStart(?string $openHoursSuStart): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_SU_START, $openHoursSuStart);
    }

    /**
     * @inheritDoc
     */
    public function getOpenHoursSuEnd(): ?string
    {
        return $this->getData(PudoInterface::OPEN_HOURS_SU_END);
    }

    /**
     * @inheritDoc
     */
    public function setOpenHoursSuEnd(?string $openHoursSuEnd): PudoInterface
    {
        return $this->setData(PudoInterface::OPEN_HOURS_SU_END, $openHoursSuEnd);
    }

    /**
     * @inheritDoc
     */
    public function getStreetNo(): ?string
    {
        return $this->getData(PudoInterface::STREET_NO);
    }

    /**
     * @inheritDoc
     */
    public function setStreetNo(?string $streetNo): PudoInterface
    {
        return $this->setData(PudoInterface::STREET_NO, $streetNo);
    }

    /**
     * @inheritDoc
     */
    public function getPhoneNumber(): ?string
    {
        return $this->getData(PudoInterface::PHONE_NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setPhoneNumber(?string $phoneNumber): PudoInterface
    {
        return $this->setData(PudoInterface::PHONE_NUMBER, $phoneNumber);
    }

    /**
     * @inheritDoc
     */
    public function getServiceCod(): int
    {
        return (int)$this->getData(PudoInterface::SERVICE_COD);
    }

    /**
     * @inheritDoc
     */
    public function setServiceCod(int $serviceCod): PudoInterface
    {
        return $this->setData(PudoInterface::SERVICE_COD, $serviceCod);
    }

    /**
     * @inheritDoc
     */
    public function getPaymentType(): int
    {
        return (int)$this->getData(PudoInterface::PAYMENT_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setPaymentType(int $paymentType): PudoInterface
    {
        return $this->setData(PudoInterface::PAYMENT_TYPE, $paymentType);
    }

    /**
     * @inheritDoc
     */
    public function getEmail(): ?string
    {
        return $this->getData(PudoInterface::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail(?string $email): PudoInterface
    {
        return $this->setData(PudoInterface::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function getAcceptedPaymentType(): ?string
    {
        return $this->getData(PudoInterface::ACCEPTED_PAYMENT_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setAcceptedPaymentType(?string $acceptedPaymentType): PudoInterface
    {
        return $this->setData(PudoInterface::ACCEPTED_PAYMENT_TYPE, $acceptedPaymentType);
    }
}
