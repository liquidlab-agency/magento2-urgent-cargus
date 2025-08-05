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
use Urgent\Base\Api\Data\CountyInterface;

/**
 * Class County
 *
 * Description: ...
 */
class County extends AbstractModel implements CountyInterface, IdentityInterface
{
    /** @var string $_idFieldName */
    protected $_idFieldName = CountyInterface::COUNTY_ID;
    /** @var string $_cacheTag */
    protected $_cacheTag = CountyInterface::TABLE_NAME;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Urgent\Base\Model\ResourceModel\Nomenclature\County::class);
    }

    /**
     * Method getIdentities
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [CountyInterface::TABLE_NAME . '_' . $this->getId()];
    }

    /**
     * Method getId
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getData(CountyInterface::COUNTY_ID);
    }

    /**
     * Method getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(CountyInterface::NAME);
    }

    /**
     * Method getAbbreviation
     *
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->getData(CountyInterface::ABBREVIATION);
    }

    /**
     * Method getCountryId
     *
     * @return int
     */
    public function getCountryId(): int
    {
        return (int)$this->getData(CountyInterface::COUNTRY_ID);
    }

    /**
     * Method getRegionId
     *
     * @return int|null
     */
    public function getRegionId(): ?int
    {
        return (int)$this->getData(CountyInterface::REGION_ID);
    }

    /**
     * Method setId
     *
     * @param $id
     * @return mixed|County
     */
    public function setId($id)
    {
        return $this->setData(CountyInterface::COUNTY_ID, $id);
    }

    /**
     * Method setName
     *
     * @param string $name
     * @return CountyInterface
     */
    public function setName(string $name): CountyInterface
    {
        return $this->setData(CountyInterface::NAME, $name);
    }

    /**
     * Method setAbbreviation
     *
     * @param string $abbreviation
     * @return CountyInterface
     */
    public function setAbbreviation(string $abbreviation): CountyInterface
    {
        return $this->setData(CountyInterface::ABBREVIATION, $abbreviation);
    }

    /**
     * Method setCountryId
     *
     * @param int $countryId
     * @return CountyInterface
     */
    public function setCountryId(int $countryId): CountyInterface
    {
        return $this->setData(CountyInterface::COUNTRY_ID, $countryId);
    }

    /**
     * Method setRegionId
     *
     * @param int|null $regionId
     * @return CountyInterface
     */
    public function setRegionId(?int $regionId = 0): CountyInterface
    {
        return $this->setData(CountyInterface::REGION_ID, $regionId);
    }
}
