<?php
    /**
 * Created by PHPStorm
 *  User: Alexandru Carabus
 *  Date: 11.09.2025
 */
declare(strict_types=1);

namespace Urgent\Base\Service;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\CityRepositoryInterface;
use Urgent\Base\Api\CountyRepositoryInterface;

/**
 * Class LocalityService
 *
 * Service class to handle locality fetching operations
 */
class LocalityService
{
    /** @var CountyRepositoryInterface */
    protected CountyRepositoryInterface $countyRepository;

    /** @var CityRepositoryInterface */
    protected CityRepositoryInterface $cityRepository;

    /**
     * Constructor
     *
     * @param CountyRepositoryInterface $countyRepository
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(
        CountyRepositoryInterface $countyRepository,
        CityRepositoryInterface   $cityRepository
    ) {
        $this->countyRepository = $countyRepository;
        $this->cityRepository = $cityRepository;
    }

    /**
     * Get localities by county name
     *
     * @param string|null $countyName
     * @return array
     */
    public function getLocalitiesByCountyName(?string $countyName): array
    {
        $response = [];

        if ($countyName === '' || $countyName === null) {
            $response['error'] = true;
            $response['message'] = __('County name is empty!');
            return $response;
        }

        if ($countyName === 'self') {
            $response['error'] = true;
            return $response;
        }

        try {
            $county = $this->countyRepository->getByName($countyName);
            if ($county->getId()) {
                $localities = $this->cityRepository->getByCountyId((int)$county->getId());
                if (count($localities)) {
                    return $localities;
                }
                $response['error'] = true;
                $response['message'] = __('No localities where found!');
                return $response;
            }
        } catch (LocalizedException|NoSuchEntityException $e) {
            $response['error'] = true;
            $response['message'] = __('Something goes wrong in the process to get localities from cargus!');
            return $response;
        }

        $response['error'] = true;
        $response['message'] = __('No county was found with %1 name!', $countyName);
        return $response;
    }

    /**
     * Get localities by county ID
     *
     * @param int $countyId
     * @return array
     */
    public function getLocalitiesByCountyId(int $countyId): array
    {
        $response = [];

        if ($countyId <= 0) {
            $response['error'] = true;
            $response['message'] = __('County ID is invalid!');
            return $response;
        }

        try {
            $county = $this->countyRepository->getById($countyId);
            if ($county->getId()) {
                $localities = $this->cityRepository->getByCountyId((int)$county->getId());
                if (count($localities)) {
                    return $localities;
                }
                $response['error'] = true;
                $response['message'] = __('No localities where found!');
                return $response;
            }
        } catch (LocalizedException|NoSuchEntityException $e) {
            $response['error'] = true;
            $response['message'] = __('Something goes wrong in the process to get localities from cargus!');
            return $response;
        }

        $response['error'] = true;
        $response['message'] = __('No county was found with ID %1!', $countyId);
        return $response;
    }
}
