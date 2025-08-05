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
use Urgent\Base\Api\Data\AwbInterface;

/**
 * Awb Repository Interface
 *
 * Description: Repository for manage object awb.
 */
interface AwbRepositoryInterface
{
    /**
     * Method save
     *
     * @param AwbInterface $awb
     * @return AwbInterface
     * @throws CouldNotSaveException
     */
    public function save(AwbInterface $awb): AwbInterface;

    /**
     * Method getById
     *
     * @param int $id
     * @return AwbInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): AwbInterface;

    /**
     * Method delete
     *
     * @param AwbInterface $awb
     * @return bool
     * @throws CouldNotSaveException
     */
    public function delete(AwbInterface $awb): bool;
}
