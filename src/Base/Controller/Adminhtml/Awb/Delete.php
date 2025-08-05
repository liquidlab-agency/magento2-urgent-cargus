<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 25.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Awb;

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

/**
 * Class Delete
 *
 * Description: ...
 */
class Delete extends Action implements HttpPostActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::awb_delete';

    /** @var AwbRepositoryInterface $_awbRepository */
    protected AwbRepositoryInterface $_awbRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param AwbRepositoryInterface $awbRepository
     */
    public function __construct(
        Context                $context,
        AwbRepositoryInterface $awbRepository
    ) {
        parent::__construct($context);
        $this->_awbRepository = $awbRepository;
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
            $this->_awbRepository->delete($awb);
        } catch (NoSuchEntityException | CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t find a AWB to delete.'));
            return $resultRedirect->setPath('*/*/');
        }

        $this->messageManager->addSuccessMessage(__('You deleted the AWB.'));
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
