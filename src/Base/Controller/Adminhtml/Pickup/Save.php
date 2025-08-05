<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 25.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Controller\Adminhtml\Pickup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Urgent\Base\Api\Data\PickupInterfaceFactory;
use Urgent\Base\Api\Data\PickupInterface;
use Urgent\Base\Api\PickupRepositoryInterface;
use Urgent\Base\Model\Api\SendOrder;

/**
 * Class Save
 *
 * Description: ...
 */
class Save extends Action implements HttpPostActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::pickup_edit';

    /** @var PickupInterfaceFactory $_pickupInterfaceFactory */
    protected PickupInterfaceFactory $_pickupInterfaceFactory;
    /** @var PickupRepositoryInterface $_pickupRepository */
    protected PickupRepositoryInterface $_pickupRepository;
    /** @var TimezoneInterface $_timezone */
    protected TimezoneInterface $_timezone;
    /** @var SendOrder $_sendOrder */
    protected SendOrder $_sendOrder;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PickupInterfaceFactory $pickupInterfaceFactory
     * @param PickupRepositoryInterface $pickupRepository
     * @param TimezoneInterface $timezone
     * @param SendOrder $sendOrder
     */
    public function __construct(
        Context                   $context,
        PickupInterfaceFactory    $pickupInterfaceFactory,
        PickupRepositoryInterface $pickupRepository,
        TimezoneInterface         $timezone,
        SendOrder                 $sendOrder
    ) {
        parent::__construct($context);
        $this->_pickupInterfaceFactory = $pickupInterfaceFactory;
        $this->_pickupRepository = $pickupRepository;
        $this->_timezone = $timezone;
        $this->_sendOrder = $sendOrder;
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
            /** @var PickupInterface $pickup */
            $pickup = $this->_pickupInterfaceFactory->create();
            $locationId = (int)$this->getRequest()->getParam(PickupInterface::LOCATION_ID);

            if ($locationId <= 0) {
                $this->messageManager->addErrorMessage(__('The location ID(%1) is invalid!', $locationId));
                return $resultRedirect->setPath('*/*/add');
            }

            $currentDate = $this->_timezone->date();
            $date = $this->getRequest()->getParam('date');
            $startHour = (int)$this->getRequest()->getParam('start_hour');
            $endHour = (int)$this->getRequest()->getParam('end_hour');
            $startDate = $this->_timezone->date($date)->setTime($startHour, 0);
            $endDate = $this->_timezone->date($date)->setTime($endHour, 0);

            if ($currentDate->diff($startDate)->invert) {
                // phpcs:disable Generic.Files.LineLength.TooLong
                $this->messageManager->addErrorMessage(
                    __('The Start date & time (%1) must be greater the Current date & time (%2)!', $startDate->format('Y-m-d H:i'), $currentDate->format('Y-m-d H:i'))
                );
                // phpcs:enable Generic.Files.LineLength.TooLong
                return $resultRedirect->setPath('*/*/add');
            }

            if ($startDate->diff($endDate)->invert) {
                // phpcs:disable Generic.Files.LineLength.TooLong
                $this->messageManager->addErrorMessage(
                    __('The End date & time (%1) must be greater the Start date & time (%2)!', $startDate->format('Y-m-d H:i'), $currentDate->format('Y-m-d H:i'))
                );
                // phpcs:enable Generic.Files.LineLength.TooLong
                return $resultRedirect->setPath('*/*/add');
            }
            $pickup->setLocationId($locationId);
            $pickup->setStartDate($startDate->format('Y-m-d H:i:s'));
            $pickup->setEndDate($endDate->format('Y-m-d H:i:s'));
            $pickup->setStatus(PickupInterface::STATUS_ACTION_SUBMIT);

            if ($this->_sendOrder->addPickupData($pickup)->execute()) {
                $this->_pickupRepository->save($pickup);
                $this->messageManager->addSuccessMessage(__('You saved the pickup.'));
                return $resultRedirect->setPath('*/*/');
            }

            $this->messageManager->addErrorMessage(__('Something went wrong! Please try again.'));
            return $resultRedirect->setPath('*/*/add');
        } catch (NoSuchEntityException|CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect->setPath('*/*/add');
        }
    }
}
