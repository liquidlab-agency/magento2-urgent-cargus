<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 23.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Order;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as SalesOrderCollectionFactory;
use Urgent\Base\Model\AddAwbGrid;

/**
 * Class MassAdd
 *
 * Description: Add multiple order to awb cargus grid for generating awb.
 */
class MassAdd extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'Urgent_Base::urgentcargus_mass_action_add';

    /** @var Filter $_filter */
    protected Filter $_filter;
    /** @var SalesOrderCollectionFactory $_collectionFactory */
    protected SalesOrderCollectionFactory $_collectionFactory;
    /** @var AddAwbGrid $_addAwbGrid */
    protected AddAwbGrid $_addAwbGrid;

    /** @var string $redirectUrl */
    protected string $redirectUrl = '*/*/';

    /**
     * Constructor
     *
     * @param Context $context
     * @param Filter $filter
     * @param SalesOrderCollectionFactory $collectionFactory
     * @param AddAwbGrid $addAwbGrid
     */
    public function __construct(
        Context $context,
        Filter $filter,
        SalesOrderCollectionFactory $collectionFactory,
        AddAwbGrid $addAwbGrid
    ) {
        parent::__construct($context);
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->_addAwbGrid = $addAwbGrid;
    }

    /**
     * Method execute
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        try {
            /** @var AbstractCollection $collection */
            $collection = $this->_filter->getCollection($this->_collectionFactory->create());
            $this->massAction($collection);
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sales/*/');
        return $resultRedirect;
    }

    /**
     * Method massAction
     *
     * @param AbstractCollection $collection
     * @return void
     */
    private function massAction(AbstractCollection $collection): void
    {
        $countAddOrder = 0;
        foreach ($collection->getItems() as $order) {
            /** @var OrderInterface $order */
            $added = $this->_addAwbGrid->execute($order);
            if ($added === false) {
                continue;
            }
            $countAddOrder++;
        }
        $countNonAddOrder = $collection->count() - $countAddOrder;

        if ($countNonAddOrder && $countAddOrder) {
            $this->messageManager->addErrorMessage(__('%1 order(s) cannot be added.', $countNonAddOrder));
        } elseif ($countNonAddOrder) {
            $this->messageManager->addErrorMessage(__('You cannot added the order(s).'));
        }

        if ($countAddOrder) {
            $this->messageManager->addSuccessMessage(__('We added %1 order(s).', $countAddOrder));
        }
    }
}
