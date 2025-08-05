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
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\CountyRepositoryInterface;
use Urgent\Base\Api\Data\CountyInterface;
use Urgent\Base\Model\ResourceModel\Nomenclature\County as CountyResource;
use Urgent\Base\Model\Nomenclature\CountyFactory;

/**
 * Class CountyRepository
 *
 * Description class.
 */
class CountyRepository implements CountyRepositoryInterface
{
    /** @var CountyResource $_countyResource */
    private CountyResource $_countyResource;
    /** @var CountyFactory $_countyFactory */
    private CountyFactory $_countyFactory;

    /**
     * Constructor
     *
     * @param CountyResource $countyResource
     * @param CountyFactory $countyFactory
     */
    public function __construct(
        CountyResource $countyResource,
        CountyFactory  $countyFactory
    ) {
        $this->_countyResource = $countyResource;
        $this->_countyFactory = $countyFactory;
    }

    /**
     * Method save
     *
     * @param CountyInterface $county
     *
     * @return CountyInterface
     * @throws CouldNotSaveException
     */
    public function save(CountyInterface $county): CountyInterface
    {
        try {
            $this->_countyResource->save($county);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $county;
    }

    /**
     * Method getById
     *
     * @param int $id
     *
     * @return CountyInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CountyInterface
    {
        $county = $this->_countyFactory->create();
        $this->_countyResource->load($county, $id, CountyInterface::COUNTY_ID);
        if (!$county->getId()) {
            throw new NoSuchEntityException(__('The county with the "%1" ID doesn\'t exist.', $id));
        }
        return $county;
    }

    /**
     * Method getByRegionId
     *
     * @param int $regionId
     * @return CountyInterface
     * @throws NoSuchEntityException
     */
    public function getByRegionId(int $regionId): CountyInterface
    {
        $county = $this->_countyFactory->create();
        $this->_countyResource->load($county, $regionId, CountyInterface::REGION_ID);
        if (!$county->getId()) {
            throw new NoSuchEntityException(__('The county with the "%1" ID doesn\'t exist.', $regionId));
        }
        return $county;
    }

    /**
     * Method getByName
     *
     * @param string $name
     * @return CountyInterface
     * @throws NoSuchEntityException
     */
    public function getByName(string $name): CountyInterface
    {
        $county = $this->_countyFactory->create();
        $this->_countyResource->load($county, $name, CountyInterface::NAME);
        if (!$county->getId()) {
            throw new NoSuchEntityException(__('The county with the "%1" name doesn\'t exist.', $name));
        }
        return $county;
    }

    /**
     * Method delete
     *
     * @param CountyInterface $county
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CountyInterface $county): bool
    {
        try {
            $this->_countyResource->delete($county);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
}
