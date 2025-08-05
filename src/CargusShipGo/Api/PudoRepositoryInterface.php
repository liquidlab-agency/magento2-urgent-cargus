<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\CargusShipGo\Api\Data\PudoInterface;

/**
 * Pudo Repository Interface
 *
 * Description: Repository for manage Pudo.
 */
interface PudoRepositoryInterface
{
    /**
     * Method save
     *
     * @param PudoInterface $pudo
     * @return PudoInterface
     * @throws CouldNotSaveException
     */
    public function save(PudoInterface $pudo): PudoInterface;

    /**
     * Method getById
     *
     * @param int $id
     * @return PudoInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): PudoInterface;

    /**
     * Method delete
     *
     * @param PudoInterface $pudo
     * @return bool
     * @throws CouldNotSaveException
     */
    public function delete(PudoInterface $pudo): bool;
}
