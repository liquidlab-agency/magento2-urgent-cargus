<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 24.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Pickup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Urgent\Base\Api\Data\PickupInterface;
use Urgent\Base\Api\PickupRepositoryInterface;
use Urgent\Base\Model\Api\SendOrder;

/**
 * Class Cancel
 *
 * Description: ...
 */
class Cancel extends Action implements HttpGetActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::pickup_cancel';

    /** @var PageFactory $resultPageFactory */
    protected PageFactory $resultPageFactory;
    /** @var PickupRepositoryInterface $pickupRepository */
    protected PickupRepositoryInterface $pickupRepository;
    /** @var SendOrder $sendOrder */
    protected SendOrder $sendOrder;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param PickupRepositoryInterface $pickupRepository
     * @param SendOrder $sendOrder
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PickupRepositoryInterface $pickupRepository,
        SendOrder $sendOrder
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->pickupRepository = $pickupRepository;
        $this->sendOrder = $sendOrder;
    }

    /**
     * Method execute
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $pickupId = (int)$this->getRequest()->getParam('id');
        if ($pickupId) {
            try {
                $pickup = $this->pickupRepository->getById($pickupId);
                if ($pickup->getId() && $pickup->getStatus()) {
                    $pickup->setStatus(PickupInterface::STATUS_ACTION_CANCEL);
                    if ($this->sendOrder->addPickupData($pickup)->execute()) {
                        $this->messageManager->addSuccessMessage(__('The pickup was canceled successfully.'));
                        return $resultRedirect->setPath('*/*/');
                    }
                }
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__("The pickup that was requested doesn't exist."));
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->messageManager->addErrorMessage(__('Something went wrong! The order was not added.'));
        return $resultRedirect->setPath('*/*/');
    }
}
