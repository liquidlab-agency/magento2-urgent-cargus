<?php
    /**
 * Created by PHPStorm
 * User: Alexandru Carabus
 * Date: 11.09.2025
 */
declare(strict_types=1);

namespace Urgent\Base\Api;

/**
 * Interface LocalityInterface
 *
 * REST API interface for locality operations
 */
interface LocalityInterface
{
    /**
     * Get localities by county ID
     *
     * @param int $countyId
     * @return array
     */
    public function getLocalitiesByCountyId(int $countyId): array;

    /**
     * Get localities by county name
     *
     * @param string $countyName
     * @return array
     */
    public function getLocalitiesByCountyName(string $countyName): array;

    /**
     * Get localities by county name using POST method with JSON payload
     *
     * @param string $countyName County name passed directly as string
     * @return array
     */
    public function getLocalitiesByCountyNamePost(string $countyName): array;
}
