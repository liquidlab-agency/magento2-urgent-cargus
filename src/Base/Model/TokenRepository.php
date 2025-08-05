<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Urgent\Base\Model\TokenFactory;
use Exception;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Model\ResourceModel\Token as TokenResource;
use Magento\Framework\Exception\CouldNotSaveException;
use Urgent\Base\Api\Data\TokenInterface;
use Urgent\Base\Api\TokenRepositoryInterface;

/**
 * Class TokenRepository
 *
 * Description class.
 */
class TokenRepository implements TokenRepositoryInterface
{
    /** @var TokenResource $_tokenResource */
    protected TokenResource $_tokenResource;
    /** @var TokenFactory $_tokenFactory */
    protected TokenFactory $_tokenFactory;

    /**
     * Constructor
     *
     * @param TokenResource $tokenResource
     * @param TokenFactory $tokenFactory
     */
    public function __construct(
        TokenResource $tokenResource,
        TokenFactory $tokenFactory
    ) {
        $this->_tokenResource = $tokenResource;
        $this->_tokenFactory = $tokenFactory;
    }

    /**
     * @inheritDoc
     */
    public function save(TokenInterface $token): TokenInterface
    {
        try {
            $this->_tokenResource->save($token);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $token;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $tokenId): TokenInterface
    {
        $token = $this->_tokenFactory->create();
        $this->_tokenResource->load($token, $tokenId);
        if (!$token->getId()) {
            throw new NoSuchEntityException(__('The token with the "%1" ID doesn\'t exist.', $tokenId));
        }
        return $token;
    }

    /**
     * @inheritDoc
     */
    public function delete(TokenInterface $token): bool
    {
        try {
            $this->_tokenResource->delete($token);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
}
