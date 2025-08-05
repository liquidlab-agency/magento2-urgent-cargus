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
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\CountryRepositoryInterface;
use Urgent\Base\Api\Data\CountryInterface;
use Urgent\Base\Api\Data\CountyInterface;
use Urgent\Base\Model\Api\Nomenclature\County;

/**
 * Class UpdateCounty
 *
 * Description: ...
 */
class UpdateCounty
{
    /** @var array $_collection */
    private array $_collection;

    /** @var CountryRepositoryInterface $_countryRepository */
    private CountryRepositoryInterface $_countryRepository;
    /** @var County $_countyApi */
    private County $_countyApi;
    /** @var ResourceConnection $_resourceConnection */
    private ResourceConnection $_resourceConnection;

    /**
     * Constructor
     *
     * @param CountryRepositoryInterface $countryRepository
     * @param County $countyApi
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        CountryRepositoryInterface $countryRepository,
        County                     $countyApi,
        ResourceConnection         $resourceConnection
    ) {
        $this->_countryRepository = $countryRepository;
        $this->_countyApi = $countyApi;
        $this->_resourceConnection = $resourceConnection;
    }

    /**
     * Method execute
     *
     * @return void
     */
    public function execute(): void
    {
        $countCountries = count($this->_collection);
        if ($countCountries > 0) {
            $connection = $this->_resourceConnection->getConnection();
            $countyTable = $this->_resourceConnection->getTableName(CountyInterface::TABLE_NAME);
            foreach ($this->_collection as $countryId) {
                try {
                    $country = $this->loadCountry((int)$countryId);
                } catch (NoSuchEntityException $e) {
                    continue;
                }
                $counties = $this->_countyApi->setCountryId((int)$country->getId())->execute();
                if (count($counties)) {
                    $countiesData = [];
                    foreach ($counties as $county) {
                        $data = [
                            CountyInterface::COUNTY_ID => $county['CountyId'],
                            CountyInterface::NAME => $county['Name'],
                            CountyInterface::ABBREVIATION => $county['Abbreviation'],
                            CountyInterface::COUNTRY_ID => (int)$countryId,
                            CountyInterface::REGION_ID => null
                        ];
                        $magentoRegion = $this->getRegion($country->getAbbreviation(), $county['Abbreviation']);
                        if (count($magentoRegion)) {
                            $data['region_id'] = (int)$magentoRegion['region_id'];
                        }
                        $countiesData[] = $data;
                    }
                    $connection->insertOnDuplicate($countyTable, $countiesData);
                }
            }
        }
    }

    /**
     * Method setCollection
     *
     * @param array $collection
     * @return UpdateCounty
     */
    public function setCollection(array $collection): UpdateCounty
    {
        $this->_collection = $collection;
        return $this;
    }

    /**
     * Method loadCountry
     *
     * @param int $countryId
     * @return CountryInterface
     * @throws NoSuchEntityException
     */
    private function loadCountry(int $countryId): CountryInterface
    {
        return $this->_countryRepository->getById($countryId);
    }

    /**
     * Method getRegion
     *
     * @param string $countryCode
     * @param string $countyAbbreviation
     * @return array
     */
    private function getRegion(string $countryCode, string $countyAbbreviation): array
    {
        $connection = $this->_resourceConnection->getConnection();

        $select = $connection->select();
        $select->from(['DCR' => $this->_resourceConnection->getTableName('directory_country_region')]);
        $select->where('DCR.country_id = ?', $countryCode);
        $select->where('DCR.code = ?', $countyAbbreviation);

        $data = $connection->fetchRow($select);
        return $data !== false ? $data : [];
    }
}
