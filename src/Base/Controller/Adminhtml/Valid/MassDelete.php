<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 25.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Valid;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Urgent\Base\Api\AwbRepositoryInterface;
use Urgent\Base\Api\Data\AwbInterface;
use Urgent\Base\Model\Api\RemoveAwb;
use Urgent\Base\Model\ResourceModel\Awb\CollectionFactory;

/**
 * Class MassDelete
 *
 * Description class.
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Urgent_Base::awb_mass_valid_delete';

    /** @var Filter $filter */
    protected Filter $filter;
    /** @var CollectionFactory $collectionFactory */
    protected CollectionFactory $collectionFactory;
    /** @var AwbRepositoryInterface $_awbRepository */
    protected AwbRepositoryInterface $_awbRepository;
    /** @var RemoveAwb $_removeAwb */
    protected RemoveAwb $_removeAwb;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param AwbRepositoryInterface $awbRepository
     * @param RemoveAwb $removeAwb
     */
    public function __construct(
        Context                $context,
        Filter                 $filter,
        CollectionFactory      $collectionFactory,
        AwbRepositoryInterface $awbRepository,
        RemoveAwb              $removeAwb
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_awbRepository = $awbRepository;
        $this->_removeAwb = $removeAwb;
    }

    /**
     * Execute action
     *
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        $counter = 0;
        foreach ($collection as $awb) {
            /** @var AwbInterface $awb */
            try {
                if ($awb->getAwbNo() && $this->_removeAwb->setAwb($awb)->execute()) {
                    $awb->setPrinted(AwbInterface::PRINTED_NO);
                    $awb->setAwbNo(null);
                    $this->_awbRepository->save($awb);
                    $counter++;
                }
            } catch (CouldNotSaveException $e) {
                continue;
            }
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been unvalidated.', $counter));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
