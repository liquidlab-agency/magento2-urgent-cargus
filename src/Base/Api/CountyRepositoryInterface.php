<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 11.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\Data\CountyInterface;

/**
 * County Repository Interface
 *
 * Description: Repository for manage object county cargus.
 */
interface CountyRepositoryInterface
{
    /**
     * Method save
     *
     * @param CountyInterface $county
     * @return CountyInterface
     * @throws CouldNotSaveException
     */
    public function save(CountyInterface $county): CountyInterface;

    /**
     * Method getById
     *
     * @param int $id
     * @return CountyInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CountyInterface;

    /**
     * Method getByRegionId
     *
     * @param int $regionId
     * @return CountyInterface
     */
    public function getByRegionId(int $regionId): CountyInterface;

    /**
     * Method getByName
     *
     * @param string $name
     * @return CountyInterface
     */
    public function getByName(string $name): CountyInterface;

    /**
     * Method delete
     *
     * @param CountyInterface $county
     * @return bool
     * @throws CouldNotSaveException
     */
    public function delete(CountyInterface $county): bool;
}
