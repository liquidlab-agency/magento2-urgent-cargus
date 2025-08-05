<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 25.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Awb;

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
use Urgent\Base\Model\Api\CreateAwb;
use Urgent\Base\Model\ResourceModel\Awb\CollectionFactory;

/**
 * Class MassValidate
 *
 * Description class.
 */
class MassValidate extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Urgent_Base::awb_mass_validate';

    /** @var Filter $filter */
    protected Filter $filter;
    /** @var CollectionFactory $collectionFactory */
    protected CollectionFactory $collectionFactory;
    /** @var CreateAwb $_createAwb */
    protected CreateAwb $_createAwb;
    /** @var AwbRepositoryInterface $_awbRepository */
    protected AwbRepositoryInterface $_awbRepository;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CreateAwb $createAwb
     * @param AwbRepositoryInterface $awbRepository
     */
    public function __construct(
        Context                $context,
        Filter                 $filter,
        CollectionFactory      $collectionFactory,
        CreateAwb              $createAwb,
        AwbRepositoryInterface $awbRepository
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_createAwb = $createAwb;
        $this->_awbRepository = $awbRepository;
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

        /** @var AwbInterface $awb */
        $counter = 0;
        foreach ($collection as $awb) {
            try {
                $awbData = $this->_createAwb->addAwbData($awb)->execute();
                if (count($awbData) > 0 && isset($awbData[0]['BarCode'])) {
                    $awbData = $awbData[0];
                    $awb->setAwbNo($awbData['BarCode']);
                    $awb->setReturnCode($awbData['ReturnCode'] !== null && $awbData['ReturnCode'] !== '' ?
                        $awbData['ReturnCode'] : null);
                    $awb->setReturnAwb($awbData['ReturnAwb'] !== null && $awbData['ReturnAwb'] !== '' ?
                        $awbData['ReturnAwb'] : null);
                    $this->_awbRepository->save($awb);
                    $counter++;
                }
            } catch (CouldNotSaveException $e) {
                continue;
            }
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been validated.', $counter));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
