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
use Urgent\Base\Api\CountryRepositoryInterface;
use Urgent\Base\Api\Data\CountryInterface;
use Urgent\Base\Model\ResourceModel\Nomenclature\Country as CountryResource;
use Urgent\Base\Model\Nomenclature\CountryFactory;

/**
 * Class CountryRepository
 *
 * Description class.
 */
class CountryRepository implements CountryRepositoryInterface
{
    /** @var CountryResource $_countryResource */
    private CountryResource $_countryResource;
    /** @var CountryFactory $_countryFactory */
    private CountryFactory $_countryFactory;

    /**
     * Constructor
     *
     * @param CountryResource $countryResource
     * @param CountryFactory $countryFactory
     */
    public function __construct(
        CountryResource $countryResource,
        CountryFactory  $countryFactory
    ) {
        $this->_countryResource = $countryResource;
        $this->_countryFactory = $countryFactory;
    }

    /**
     * Method save
     *
     * @param CountryInterface $country
     *
     * @return CountryInterface
     * @throws CouldNotSaveException
     */
    public function save(CountryInterface $country): CountryInterface
    {
        try {
            $this->_countryResource->save($country);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $country;
    }

    /**
     * Method getById
     *
     * @param int $id
     *
     * @return CountryInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CountryInterface
    {
        $country = $this->_countryFactory->create();
        $this->_countryResource->load($country, $id, CountryInterface::COUNTRY_ID);
        if (!$country->getId()) {
            throw new NoSuchEntityException(__('The country with the "%1" ID doesn\'t exist.', $id));
        }
        return $country;
    }

    /**
     * Method delete
     *
     * @param CountryInterface $country
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CountryInterface $country): bool
    {
        try {
            $this->_countryResource->delete($country);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
}
