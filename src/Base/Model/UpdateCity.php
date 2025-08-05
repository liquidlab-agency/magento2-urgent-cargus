<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 11.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Magento\Framework\App\ResourceConnection;
use Urgent\Base\Api\Data\CityInterface;
use Urgent\Base\Api\Data\CountyInterface;
use Urgent\Base\Model\Api\Nomenclature\City;
use Urgent\Base\Model\ResourceModel\Nomenclature\County\Collection;
use Urgent\Base\Model\ResourceModel\Nomenclature\County\CollectionFactory as CountyCollectionFactory;

/**
 * Class UpdateCity
 *
 * Description: ...
 */
class UpdateCity
{
    /** @var Collection $_collection */
    private Collection $_collection;

    /** @var City $_cityApi */
    private City $_cityApi;
    /** @var CountyCollectionFactory $_collectionFactory */
    private CountyCollectionFactory $_collectionFactory;
    /** @var ResourceConnection $_resourceConnection */
    private ResourceConnection $_resourceConnection;

    /**
     * Constructor
     *
     * @param City $cityApi
     * @param CountyCollectionFactory $collectionFactory
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        City                    $cityApi,
        CountyCollectionFactory $collectionFactory,
        ResourceConnection      $resourceConnection
    ) {
        $this->_cityApi = $cityApi;
        $this->_collectionFactory = $collectionFactory;
        $this->_resourceConnection = $resourceConnection;
        $this->setCollection();
    }

    /**
     * Method execute
     *
     * @return void
     */
    public function execute(): void
    {
        if ($this->_collection->getSize()) {
            /** @var CountyInterface $county */
            $connection = $this->_resourceConnection->getConnection();
            $cityTable = $this->_resourceConnection->getTableName(CityInterface::TABLE_NAME);
            foreach ($this->_collection->getItems() as $county) {
                $cities = $this->_cityApi
                    ->setCountryId($county->getCountryId())
                    ->setCountyId((int)$county->getId())
                    ->execute();
                if (count($cities)) {
                    $citiesData = [];
                    foreach ($cities as $city) {
                        $data = [
                            CityInterface::LOCALITY_ID => $city['LocalityId'],
                            CityInterface::NAME => $city['Name'],
                            CityInterface::PARENT_ID => $city['ParentId'],
                            CityInterface::PARENT_NAME => $city['ParentName'],
                            CityInterface::EXTRA_KM => $city['ExtraKm'],
                            CityInterface::IN_NETWORK => $city['InNetwork'],
                            CityInterface::COUNTY_ID => $city['CountyId'],
                            CityInterface::COUNTRY_ID => $city['CountryId'],
                            CityInterface::POSTAL_CODE => $city['PostalCode'],
                            CityInterface::MAX_HOUR => $city['MaxHour'],
                            CityInterface::SATURDAY_DELIVERY => $city['SaturdayDelivery'],
                        ];
                        $citiesData[] = $data;
                    }
                    $connection->insertOnDuplicate($cityTable, $citiesData);
                }
            }
        }
    }

    /**
     * Method setCollection
     *
     * @return void
     */
    private function setCollection(): void
    {
        $this->_collection = $this->_collectionFactory->create();
    }
}
