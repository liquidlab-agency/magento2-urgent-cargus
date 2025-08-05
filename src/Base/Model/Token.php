<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Urgent\Base\Api\Data\TokenInterface;

/**
 * Class Token Model
 *
 * Description class.
 */
class Token extends AbstractModel implements TokenInterface, IdentityInterface
{
    protected $_cacheTag = TokenInterface::TABLE_NAME;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Token::class);
    }

    /**
     * Method getIdentities
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [TokenInterface::TABLE_NAME . '_' . $this->getId()];
    }

    /**
     * Method getId
     *
     * @return int|null
     */
    public function getId()
    {
        return parent::getData(TokenInterface::ID);
    }

    /**
     * Method getToken
     *
     * @return string
     */
    public function getToken(): string
    {
        return parent::getData(TokenInterface::TOKEN);
    }

    /**
     * Method getAvailable
     *
     * @return string
     */
    public function getAvailable(): string
    {
        return parent::getData(TokenInterface::AVAILABLE);
    }

    /**
     * Method setId
     *
     * @param $id
     * @return TokenInterface|Token
     */
    public function setId($id)
    {
        return $this->setData(TokenInterface::ID, $id);
    }

    /**
     * Method setToken
     *
     * @param string $token
     * @return TokenInterface
     */
    public function setToken(string $token): TokenInterface
    {
        return $this->setData(TokenInterface::TOKEN, $token);
    }

    /**
     * Method setAvailable
     *
     * @param string $available
     * @return TokenInterface
     */
    public function setAvailable(string $available): TokenInterface
    {
        return $this->setData(TokenInterface::AVAILABLE, $available);
    }
}
