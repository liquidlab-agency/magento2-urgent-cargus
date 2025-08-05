<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Api\Data;

/**
 * Token Interface
 *
 * Description: Token Structure of object.
 */
interface TokenInterface
{
    public const TABLE_NAME = 'urgent_cargus_token';

    public const ID = 'id';
    public const TOKEN = 'token';
    public const AVAILABLE = 'available';

    /**
     * Method getId
     *
     * @return int|null
     */
    public function getId();

    /**
     * Method getToken
     *
     * @return string
     */
    public function getToken(): string;

    /**
     * Method getAvailable
     *
     * @return string
     */
    public function getAvailable(): string;

    /**
     * Method setId
     *
     * @param $id
     * @return TokenInterface
     */
    public function setId($id);

    /**
     * Method setToken
     *
     * @param string $token
     * @return TokenInterface
     */
    public function setToken(string $token): TokenInterface;

    /**
     * Method setAvailable
     *
     * @param string $available
     * @return TokenInterface
     */
    public function setAvailable(string $available): TokenInterface;
}
