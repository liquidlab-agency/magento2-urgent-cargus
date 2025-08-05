<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\Data\TokenInterface;

/**
 * Token Repository Interface
 *
 * Description: Repository for manage token for access cargus api.
 */
interface TokenRepositoryInterface
{
    /**
     * Method save
     *
     * @param TokenInterface $token
     * @return TokenInterface
     * @throws CouldNotSaveException
     */
    public function save(TokenInterface $token): TokenInterface;

    /**
     * Method getById
     *
     * @param int $tokenId
     * @return TokenInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $tokenId): TokenInterface;

    /**
     * Method delete
     *
     * @param TokenInterface $token
     * @return bool
     * @throws CouldNotSaveException
     */
    public function delete(TokenInterface $token): bool;
}
