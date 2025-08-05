<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 25.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Valid;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\AwbRepositoryInterface;
use Urgent\Base\Api\Data\AwbInterface;
use Urgent\Base\Model\Api\RemoveAwb;

/**
 * Class Delete
 *
 * Description: Delete valid awb from cargus platform by calling an API.
 */
class Delete extends Action implements HttpPostActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::awb_valid_print';

    /** @var AwbRepositoryInterface $_awbRepository */
    protected AwbRepositoryInterface $_awbRepository;
    /** @var RemoveAwb $_removeAwb */
    protected RemoveAwb $_removeAwb;

    /**
     * Constructor
     *
     * @param Context $context
     * @param AwbRepositoryInterface $awbRepository
     * @param RemoveAwb $removeAwb
     */
    public function __construct(
        Context                $context,
        AwbRepositoryInterface $awbRepository,
        RemoveAwb              $removeAwb
    ) {
        parent::__construct($context);
        $this->_awbRepository = $awbRepository;
        $this->_removeAwb = $removeAwb;
    }

    /**
     * Method execute
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $awb = $this->_initAwb();
            if ($awb->getAwbNo() && $this->_removeAwb->setAwb($awb)->execute()) {
                $awb->setPrinted(AwbInterface::PRINTED_NO);
                $awb->setAwbNo(null);
                $this->_awbRepository->save($awb);
                $this->messageManager->addSuccessMessage(__('You unvalidated the AWB.'));
                return $resultRedirect->setPath('*/*/');
            }
            throw new NoSuchEntityException();
        } catch (NoSuchEntityException|CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t unvalidated this AWB.'));
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Method _initAwb
     *
     * @return AwbInterface
     * @throws NoSuchEntityException
     */
    private function _initAwb(): AwbInterface
    {
        $awbId = (int)$this->getRequest()->getParam(AwbInterface::ID);
        return $this->_awbRepository->getById($awbId);
    }
}
