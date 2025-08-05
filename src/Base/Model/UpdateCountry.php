<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 11.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Urgent\Base\Api\CountryRepositoryInterface;
use Urgent\Base\Api\Data\CountryInterface;
use Urgent\Base\Api\Data\CountryInterfaceFactory;
use Urgent\Base\Model\Api\Nomenclature\Country;

/**
 * Class UpdateCountry
 *
 * Description: ...
 */
class UpdateCountry
{
    /** @var Country $_countryApi */
    private Country $_countryApi;
    /** @var CountryInterfaceFactory $_countryInterfaceFactory */
    private CountryInterfaceFactory $_countryInterfaceFactory;
    /** @var CountryRepositoryInterface $_countryRepository */
    private CountryRepositoryInterface $_countryRepository;

    /**
     * Constructor
     *
     * @param Country $countryApi
     * @param CountryInterfaceFactory $countryInterfaceFactory
     * @param CountryRepositoryInterface $countryRepository
     */
    public function __construct(
        Country                    $countryApi,
        CountryInterfaceFactory    $countryInterfaceFactory,
        CountryRepositoryInterface $countryRepository
    ) {
        $this->_countryApi = $countryApi;
        $this->_countryInterfaceFactory = $countryInterfaceFactory;
        $this->_countryRepository = $countryRepository;
    }

    /**
     * Method execute
     *
     * @return array
     */
    public function execute(): array
    {
        $result = [];
        $countries = $this->_countryApi->execute();
        $countCountries = count($countries);
        if ($countCountries > 0) {
            foreach ($countries as $country) {
                /** @var CountryInterface $countryObj */
                $countryObj = $this->_countryInterfaceFactory->create();
                $countryObj->setId($country['CountryId']);
                $countryObj->setCountryName($country['CountryName']);
                $countryObj->setAbbreviation($country['Abbreviation']);
                try {
                    $this->_countryRepository->save($countryObj);
                    $result[] = $countryObj;
                } catch (CouldNotSaveException $e) {
                    continue;
                }
            }
            return $result;
        }
        return [];
    }
}
