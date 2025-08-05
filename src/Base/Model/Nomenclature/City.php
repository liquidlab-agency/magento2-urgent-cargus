<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 09.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Nomenclature;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Urgent\Base\Api\Data\CityInterface;

/**
 * Class City
 *
 * Description: ...
 */
class City extends AbstractModel implements CityInterface, IdentityInterface
{
    /** @var string $_idFieldName */
    protected $_idFieldName = CityInterface::LOCALITY_ID;
    /** @var string $_cacheTag */
    protected $_cacheTag = CityInterface::TABLE_NAME;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Urgent\Base\Model\ResourceModel\Nomenclature\City::class);
    }

    /**
     * Method getIdentities
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [CityInterface::TABLE_NAME . '_' . $this->getId()];
    }

    /**
     * Method getId
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getData(CityInterface::LOCALITY_ID);
    }

    /**
     * Method getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(CityInterface::NAME);
    }

    /**
     * Method getParentId
     *
     * @return int
     */
    public function getParentId(): int
    {
        return (int)$this->getData(CityInterface::PARENT_ID);
    }

    /**
     * Method getParentName
     *
     * @return string
     */
    public function getParentName(): string
    {
        return $this->getData(CityInterface::PARENT_NAME);
    }

    /**
     * Method getExtraKm
     *
     * @return int
     */
    public function getExtraKm(): int
    {
        return (int)$this->getData(CityInterface::EXTRA_KM);
    }

    /**
     * Method getInNetwork
     *
     * @return bool
     */
    public function getInNetwork(): bool
    {
        return (bool)$this->getData(CityInterface::IN_NETWORK);
    }

    /**
     * Method getCountyId
     *
     * @return int
     */
    public function getCountyId(): int
    {
        return (int)$this->getData(CityInterface::COUNTY_ID);
    }

    /**
     * Method getCountryId
     *
     * @return int
     */
    public function getCountryId(): int
    {
        return (int)$this->getData(CityInterface::COUNTRY_ID);
    }

    /**
     * Method getPostalCode
     *
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->getData(CityInterface::POSTAL_CODE);
    }

    /**
     * Method getMaxHour
     *
     * @return string
     */
    public function getMaxHour(): string
    {
        return $this->getData(CityInterface::MAX_HOUR);
    }

    /**
     * Method getSaturdayDelivery
     *
     * @return bool
     */
    public function getSaturdayDelivery(): bool
    {
        return (bool)$this->getData(CityInterface::SATURDAY_DELIVERY);
    }

    /**
     * Method setId
     *
     * @param $id
     * @return mixed|County
     */
    public function setId($id)
    {
        return $this->setData(CityInterface::LOCALITY_ID, $id);
    }

    /**
     * Method setName
     *
     * @param string $name
     * @return CityInterface
     */
    public function setName(string $name): CityInterface
    {
        return $this->setData(CityInterface::NAME, $name);
    }

    /**
     * Method setParentId
     *
     * @param int $parentId
     * @return CityInterface
     */
    public function setParentId(int $parentId): CityInterface
    {
        return $this->setData(CityInterface::PARENT_ID, $parentId);
    }

    /**
     * Method setParentName
     *
     * @param string $parentName
     * @return CityInterface
     */
    public function setParentName(string $parentName): CityInterface
    {
        return $this->setData(CityInterface::PARENT_NAME, $parentName);
    }

    /**
     * Method setExtraKm
     *
     * @param int $extraKm
     * @return CityInterface
     */
    public function setExtraKm(int $extraKm): CityInterface
    {
        return $this->setData(CityInterface::EXTRA_KM, $extraKm);
    }

    /**
     * Method setInNetwork
     *
     * @param bool $inNetwork
     * @return CityInterface
     */
    public function setInNetwork(bool $inNetwork): CityInterface
    {
        return $this->setData(CityInterface::IN_NETWORK, (int)$inNetwork);
    }

    /**
     * Method setCountyId
     *
     * @param int $countyId
     * @return CityInterface
     */
    public function setCountyId(int $countyId): CityInterface
    {
        return $this->setData(CityInterface::COUNTY_ID, $countyId);
    }

    /**
     * Method setCountryId
     *
     * @param int $countryId
     * @return CityInterface
     */
    public function setCountryId(int $countryId): CityInterface
    {
        return $this->setData(CityInterface::COUNTRY_ID, $countryId);
    }

    /**
     * Method setPostalCode
     *
     * @param string $postalCode
     * @return CityInterface
     */
    public function setPostalCode(string $postalCode): CityInterface
    {
        return $this->setData(CityInterface::POSTAL_CODE, $postalCode);
    }

    /**
     * Method setMaxHour
     *
     * @param string $maxHour
     * @return CityInterface
     */
    public function setMaxHour(string $maxHour): CityInterface
    {
        return $this->setData(CityInterface::MAX_HOUR, $maxHour);
    }

    /**
     * Method setSaturdayDelivery
     *
     * @param bool $saturdayDelivery
     * @return CityInterface
     */
    public function setSaturdayDelivery(bool $saturdayDelivery): CityInterface
    {
        return $this->setData(CityInterface::SATURDAY_DELIVERY, (int)$saturdayDelivery);
    }
}
