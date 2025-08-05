<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\Data\PickupInterface;

/**
 * Pickup Repository Interface
 *
 * Description: Repository for manage object awb.
 */
interface PickupRepositoryInterface
{
    /**
     * Method save
     *
     * @param PickupInterface $pickup
     * @return PickupInterface
     * @throws CouldNotSaveException
     */
    public function save(PickupInterface $pickup): PickupInterface;

    /**
     * Method getById
     *
     * @param int $id
     * @return PickupInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): PickupInterface;

    /**
     * Method delete
     *
     * @param PickupInterface $pickup
     * @return bool
     * @throws CouldNotSaveException
     */
    public function delete(PickupInterface $pickup): bool;
}
