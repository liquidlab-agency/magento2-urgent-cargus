<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 27.06.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Pickup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * Description: Send order for pickup packages
 */
class Index extends Action implements HttpGetActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::pickup_grid';

    /** @var PageFactory $resultPageFactory */
    protected PageFactory $resultPageFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Method execute
     *
     * @return Page
     */
    public function execute(): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Urgent_Base::pickup_grid');
        $resultPage->getConfig()->getTitle()->prepend(__("Cargus Pickup"));
        return $resultPage;
    }
}
