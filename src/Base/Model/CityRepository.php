<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 11.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Exception;
use Magento\Framework\DB\Select;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\CityRepositoryInterface;
use Urgent\Base\Api\Data\CityInterface;
use Urgent\Base\Model\ResourceModel\Nomenclature\City as cityResource;
use Urgent\Base\Model\Nomenclature\CityFactory;

/**
 * Class CityRepository
 *
 * Description class.
 */
class CityRepository implements CityRepositoryInterface
{
    /** @var CityResource $_cityResource */
    private CityResource $_cityResource;
    /** @var CityFactory $_cityFactory */
    private CityFactory $_cityFactory;

    /**
     * Constructor
     *
     * @param CityResource $cityResource
     * @param CityFactory $cityFactory
     */
    public function __construct(
        CityResource $cityResource,
        CityFactory  $cityFactory
    ) {
        $this->_cityResource = $cityResource;
        $this->_cityFactory = $cityFactory;
    }

    /**
     * Method save
     *
     * @param CityInterface $city
     *
     * @return CityInterface
     * @throws CouldNotSaveException
     */
    public function save(CityInterface $city): CityInterface
    {
        try {
            $this->_cityResource->save($city);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $city;
    }

    /**
     * Method getById
     *
     * @param int $id
     *
     * @return CityInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CityInterface
    {
        $city = $this->_cityFactory->create();
        $this->_cityResource->load($city, $id, CityInterface::LOCALITY_ID);
        if (!$city->getId()) {
            throw new NoSuchEntityException(__('The city with the "%1" ID doesn\'t exist.', $id));
        }
        return $city;
    }

    /**
     * Method getByCountyId
     *
     * @param int $countyId
     * @return array
     * @throws LocalizedException
     */
    public function getByCountyId(int $countyId): array
    {
        $query = $this->_cityResource->getConnection()
            ->select()
            ->from($this->_cityResource->getMainTable())
            ->where(CityInterface::COUNTY_ID . ' = ?', $countyId);
        return $this->_cityResource->getConnection()->fetchAll($query);
    }

    /**
     * Method getByCountyIdAndCityName
     *
     * @param int $countyId
     * @param string $cityName
     * @return array
     * @throws LocalizedException
     */
    public function getByCountyIdAndCityName(int $countyId, string $cityName): array
    {
        $query = $this->_cityResource->getConnection()
            ->select()
            ->from($this->_cityResource->getMainTable())
            ->where(CityInterface::COUNTY_ID . ' = ?', $countyId)
            ->where(CityInterface::NAME . ' = ?', $cityName);

        return $this->_cityResource->getConnection()->fetchRow($query);
    }

    /**
     * Method delete
     *
     * @param CityInterface $city
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CityInterface $city): bool
    {
        try {
            $this->_cityResource->delete($city);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
}
