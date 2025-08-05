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
use Urgent\Base\Api\Data\CityInterface;
use Urgent\Base\Api\Data\CountyInterface;

/**
 * City Repository Interface
 *
 * Description: Repository for manage object city cargus.
 */
interface CityRepositoryInterface
{
    /**
     * Method save
     *
     * @param CityInterface $city
     * @return CityInterface
     * @throws CouldNotSaveException
     */
    public function save(CityInterface $city): CityInterface;

    /**
     * Method getById
     *
     * @param int $id
     * @return CityInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CityInterface;

    /**
     * Method delete
     *
     * @param CityInterface $city
     * @return bool
     * @throws CouldNotSaveException
     */
    public function delete(CityInterface $city): bool;
}
