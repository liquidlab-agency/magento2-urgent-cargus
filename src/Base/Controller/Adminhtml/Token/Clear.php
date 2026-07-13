<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 28.02.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Token;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Controller\Result\Redirect;
use Urgent\Base\Api\Data\TokenInterface;

/**
 * Class Country
 *
 * Description: ...
 */
class Clear extends Action implements HttpPostActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::config';

    /** @var ResourceConnection $resourceConnection */
    private ResourceConnection $resourceConnection;

    /**
     * Constructor
     *
     * @param Context $context
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        Context            $context,
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context);
    }


    /**
     * Method execute
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $connection = $this->resourceConnection->getConnection();

        $connection->truncateTable($this->resourceConnection->getTableName(TokenInterface::TABLE_NAME));
        $this->messageManager->addSuccessMessage(__('Success!'));
        return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
    }
}
