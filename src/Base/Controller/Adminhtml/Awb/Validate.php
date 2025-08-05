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
use Urgent\Base\Model\Api\CreateAwb;

/**
 * Class Validate
 *
 * Description: ...
 */
class Validate extends Action implements HttpPostActionInterface
{

    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::awb_validate';

    /** @var AwbRepositoryInterface $_awbRepository */
    protected AwbRepositoryInterface $_awbRepository;
    /** @var CreateAwb $_createAwb */
    protected CreateAwb $_createAwb;

    /**
     * Constructor
     *
     * @param Context $context
     * @param AwbRepositoryInterface $awbRepository
     * @param CreateAwb $createAwb
     */
    public function __construct(
        Context                $context,
        AwbRepositoryInterface $awbRepository,
        CreateAwb              $createAwb
    ) {
        parent::__construct($context);
        $this->_awbRepository = $awbRepository;
        $this->_createAwb = $createAwb;
    }

    /**
     * Method execute
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $awb = null;
        try {
            $awb = $this->_initAwb();
            $awbData = $this->_createAwb->addAwbData($awb)->execute();
            if (count($awbData) <= 0 || !isset($awbData[0]['BarCode'])) {
                $this->messageManager->addErrorMessage($awbData['body']);
                return $resultRedirect->setPath('*/*/edit', ['id' => $awb->getId()]);
            }
            $awbData = $awbData[0];
            $awb->setAwbNo($awbData['BarCode']);
            $awb->setReturnCode($awbData['ReturnCode'] !== null && $awbData['ReturnCode'] !== '' ?
                $awbData['ReturnCode'] : null);
            $awb->setReturnAwb($awbData['ReturnAwb'] !== null && $awbData['ReturnAwb'] !== '' ?
                $awbData['ReturnAwb'] : null);
            $this->_awbRepository->save($awb);
        } catch (NoSuchEntityException|CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            if ($awb !== null) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $awb->getId()]);
            }
            return $resultRedirect->setPath('*/*/');
        }

        $this->messageManager->addSuccessMessage(__('You validated the AWB.'));
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
