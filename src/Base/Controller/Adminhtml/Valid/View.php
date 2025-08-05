<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 24.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Valid;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class View
 *
 * Description: ...
 */
class View extends Action implements HttpGetActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::awb_view';

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
        $resultPage->setActiveMenu('Urgent_Base::awb_view');
        $resultPage->getConfig()->getTitle()->prepend(__("Cargus AWB View"));
        return $resultPage;
    }
}
