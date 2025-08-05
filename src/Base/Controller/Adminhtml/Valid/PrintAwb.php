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
use Magento\Cms\Helper\Wysiwyg\Images;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\AwbRepositoryInterface;
use Urgent\Base\Api\Data\AwbInterface;
use Urgent\Base\Model\Api\PrintAwb as PrintAwbAPI;
use Urgent\Base\Ui\Component\Valid\Listing\Column\Actions;

/**
 * Class PrintAwb
 *
 * Description: Print AWB document from cargus platform by calling an API.
 */
class PrintAwb extends Action implements HttpGetActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::awb_valid_print';

    /** @var AwbRepositoryInterface $_awbRepository */
    protected AwbRepositoryInterface $_awbRepository;
    /** @var PrintAwbAPI $_printAwb */
    protected PrintAwbAPI $_printAwb;
    /** @var Images $_images */
    protected Images $_images;

    /**
     * Constructor
     *
     * @param Context $context
     * @param AwbRepositoryInterface $awbRepository
     * @param PrintAwbAPI $printAwb
     * @param Images $images
     */
    public function __construct(
        Context                $context,
        AwbRepositoryInterface $awbRepository,
        PrintAwbAPI            $printAwb,
        Images                 $images
    ) {
        parent::__construct($context);
        $this->_awbRepository = $awbRepository;
        $this->_printAwb = $printAwb;
        $this->_images = $images;
    }

    /**
     * Method execute
     *
     * @return ResponseInterface|Redirect|ResultInterface|bool
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $awb = $this->_initAwb();
            if ($awb->getAwbNo() &&
                $awbData = $this->_printAwb->setAwb($awb)->setPrintType($this->getPrintType())->execute()
            ) {
                $awb->setPrinted(AwbInterface::PRINTED_YES);
                $this->_awbRepository->save($awb);
                /** @var Http $response */
                $response = $this->_response;
                $response->setHeader('Content-Type', 'application/pdf');
                $response->setContent($this->_images->idDecode($awbData));
                $response->sendResponse();
                return true;
            }
            throw new NoSuchEntityException();
        } catch (NoSuchEntityException|CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t print this AWB.'));
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

    /**
     * Method getPrintType
     *
     * @return int
     */
    private function getPrintType(): int
    {
        return (int)$this->getRequest()->getParam('print_type', Actions::TYPE_PRINT_ONLY_AWB);
    }
}
