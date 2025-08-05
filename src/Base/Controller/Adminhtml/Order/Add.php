<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 27.06.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Urgent\Base\Model\AddAwbGrid;

/**
 * Class Add
 *
 * Description: ...
 */
class Add extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Urgent_Base::urgentcargus_mass_action_add';

    /** @var AddAwbGrid $addAwbGrid */
    protected AddAwbGrid $addAwbGrid;
    /** @var OrderRepositoryInterface $orderRepository */
    protected OrderRepositoryInterface $orderRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param AddAwbGrid $addAwbGrid
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        Context $context,
        AddAwbGrid $addAwbGrid,
        OrderRepositoryInterface $orderRepository
    ) {
        parent::__construct($context);
        $this->addAwbGrid = $addAwbGrid;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Method execute
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $orderId = (int)$this->getRequest()->getParam('order_id');
        if ($orderId > 0) {
            $order = $this->orderRepository->get($orderId);
            try {
                if ($order->getEntityId() && $this->addAwbGrid->execute($order)) {
                    $this->messageManager->addSuccessMessage(__('The order was added successfully.'));
                    return $resultRedirect->setPath('sales/order/view', ['order_id' => $order->getEntityId()]);
                }
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__("The order that was requested doesn't exist."));
                return $resultRedirect->setPath('sales/order/index');
            }
        }
        $this->messageManager->addErrorMessage(__('Something went wrong! The order was not added.'));
        return $resultRedirect->setPath('sales/order/index');
    }
}
