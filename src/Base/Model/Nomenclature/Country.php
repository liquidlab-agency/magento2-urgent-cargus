<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 09.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Nomenclature;

use Magento\Framework\Model\AbstractModel;
use Urgent\Base\Api\Data\CountryInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Country
 *
 * Description: ...
 */
class Country extends AbstractModel implements CountryInterface, IdentityInterface
{
    /** @var string $_idFieldName */
    protected $_idFieldName = CountryInterface::COUNTRY_ID;
    /** @var string $_cacheTag */
    protected $_cacheTag = CountryInterface::TABLE_NAME;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Urgent\Base\Model\ResourceModel\Nomenclature\Country::class);
    }

    /**
     * Method getIdentities
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [CountryInterface::TABLE_NAME . '_' . $this->getId()];
    }

    /**
     * Method getId
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getData(CountryInterface::COUNTRY_ID);
    }

    /**
     * @inheritDoc
     */
    public function getCountryName(): string
    {
        return $this->getData(CountryInterface::COUNTRY_NAME);
    }

    /**
     * @inheritDoc
     */
    public function getAbbreviation(): string
    {
        return $this->getData(CountryInterface::ABBREVIATION);
    }

    /**
     * Method setId
     *
     * @param $id
     * @return mixed|Country
     */
    public function setId($id)
    {
        return $this->setData(CountryInterface::COUNTRY_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function setCountryName(string $countryName): CountryInterface
    {
        return $this->setData(CountryInterface::COUNTRY_NAME, $countryName);
    }

    /**
     * @inheritDoc
     */
    public function setAbbreviation(string $abbreviation): CountryInterface
    {
        return $this->setData(CountryInterface::ABBREVIATION, $abbreviation);
    }
}
