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
use Urgent\Base\Api\Data\CountryInterface;

/**
 * Country Repository Interface
 *
 * Description: Repository for manage object country cargus.
 */
interface CountryRepositoryInterface
{
    /**
     * Method save
     *
     * @param CountryInterface $country
     * @return CountryInterface
     * @throws CouldNotSaveException
     */
    public function save(CountryInterface $country): CountryInterface;

    /**
     * Method getById
     *
     * @param int $id
     * @return CountryInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CountryInterface;

    /**
     * Method delete
     *
     * @param CountryInterface $country
     * @return bool
     * @throws CouldNotSaveException
     */
    public function delete(CountryInterface $country): bool;
}
