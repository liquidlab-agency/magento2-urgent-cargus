<?php
/**
 * Created by PHPStorm
 *  User: Alexandru Carabus
 *  Date: 11.09.2025
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Api;

use Urgent\Base\Api\LocalityInterface;
use Urgent\Base\Service\LocalityService;

/**
 * Class LocalityManagement
 *
 * REST API implementation for locality operations
 */
class LocalityManagement implements LocalityInterface
{
    /** @var LocalityService */
    protected LocalityService $localityService;

    /**
     * Constructor
     *
     * @param LocalityService $localityService
     */
    public function __construct(
        LocalityService $localityService
    ) {
        $this->localityService = $localityService;
    }

    /**
     * Get localities by county ID
     *
     * @param int $countyId
     * @return array
     */
    public function getLocalitiesByCountyId(int $countyId): array
    {
        return $this->localityService->getLocalitiesByCountyId($countyId);
    }

    /**
     * Get localities by county name
     *
     * @param string $countyName
     * @return array
     */
    public function getLocalitiesByCountyName(string $countyName): array
    {
        return $this->localityService->getLocalitiesByCountyName($countyName);
    }

    /**
     * Get localities by county name using POST method with JSON payload
     *
     * This method is specifically designed to handle POST requests
     * with JSON payloads containing the county name.
     *
     * @param string $countyName County name passed directly as string
     * @return array
     */
    public function getLocalitiesByCountyNamePost(string $countyName): array
    {
        return $this->localityService->getLocalitiesByCountyName($countyName);
    }
}
