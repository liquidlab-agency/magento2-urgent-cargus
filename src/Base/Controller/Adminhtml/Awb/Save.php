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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Urgent\Base\Api\AwbRepositoryInterface;
use Urgent\Base\Api\CityRepositoryInterface;
use Urgent\Base\Api\CountyRepositoryInterface;
use Urgent\Base\Api\Data\AwbInterface;
use Urgent\Base\Api\Data\CityInterface;
use Urgent\Base\Api\Data\CountyInterface;
use Urgent\Base\Model\CityRepository;

/**
 * Class Save
 *
 * Description: ...
 */
class Save extends Action implements HttpPostActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Urgent_Base::awb_save';

    /** @var AwbRepositoryInterface $_awbRepository */
    protected AwbRepositoryInterface $_awbRepository;
    /** @var CountyRepositoryInterface $_countyRepository */
    protected CountyRepositoryInterface $_countyRepository;
    /** @var CityRepositoryInterface $_cityRepository */
    protected CityRepositoryInterface $_cityRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param AwbRepositoryInterface $awbRepository
     * @param CountyRepositoryInterface $countyRepository
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(
        Context                $context,
        AwbRepositoryInterface $awbRepository,
        CountyRepositoryInterface $countyRepository,
        CityRepositoryInterface $cityRepository
    ) {
        parent::__construct($context);
        $this->_awbRepository = $awbRepository;
        $this->_countyRepository = $countyRepository;
        $this->_cityRepository = $cityRepository;
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
            $data = $this->getRequest()->getPostValue();

            $destinationCounty = null;
            $destinationCountyName = $data['customer_county'];
            $destinationCountyId = 0;
            if ($data[AwbInterface::DESTINATION_COUNTY] !== 'self') {
                $destinationCounty = $this->getCounty($data[AwbInterface::DESTINATION_COUNTY]);
            }

            $destinationLocalityId = 0;
            $destinationLocalityName = $data['customer_locality'];
            if ($destinationCounty instanceof CountyInterface) {
                $destinationCountyId = (int)$destinationCounty->getId();
                $destinationCountyName = $destinationCounty->getName();

                $destinationLocality = $this->getLocality($destinationCountyId, $data['destination_locality']);
                if (is_array($destinationLocality)) {
                    $destinationLocalityId = (int)$destinationLocality[CityInterface::LOCALITY_ID];
                    $destinationLocalityName = $destinationLocality[CityInterface::NAME];
                }
            }

            $awb->setPickupLocationId((int)$data[AwbInterface::PICKUP_LOCATION_ID]);
            $awb->setRecipientName(trim($data[AwbInterface::RECIPIENT_NAME]));
            $awb->setCountyId($destinationCountyId);
            $awb->setDestinationCounty($destinationCountyName);
            $awb->setLocalityId($destinationLocalityId);
            $awb->setDestinationLocality($destinationLocalityName);
            $awb->setDestinationAddress(trim($data[AwbInterface::DESTINATION_ADDRESS]));
            $awb->setRecipientContact(trim($data[AwbInterface::RECIPIENT_CONTACT]));
            $awb->setRecipientPhone($data[AwbInterface::RECIPIENT_PHONE]);
            $awb->setRecipientEmail(trim($data[AwbInterface::RECIPIENT_EMAIL]));
            $awb->setZipCode($data[AwbInterface::ZIP_CODE]);
            $awb->setEnvelope((int)$data[AwbInterface::ENVELOPE]);
            $awb->setParcel((int)$data[AwbInterface::PARCEL]);
            $awb->setWeight((int)$data[AwbInterface::WEIGHT]);
            $awb->setLength((int)$data[AwbInterface::LENGTH]);
            $awb->setWidth((int)$data[AwbInterface::WIDTH]);
            $awb->setHeight((int)$data[AwbInterface::HEIGHT]);
            $awb->setDeclaredValue((float)$data[AwbInterface::DECLARED_VALUE]);
            $awb->setCashRefunds((float)$data[AwbInterface::CASH_REFUNDS]);
            $awb->setAccountRefunds((float)$data[AwbInterface::ACCOUNT_REFUNDS]);
            $awb->setOtherRepayment(trim($data[AwbInterface::OTHER_REPAYMENT]));
            $awb->setShippingPayer((int)$data[AwbInterface::SHIPPING_PAYER]);
            $awb->setSaturdayDelivery((int)$data[AwbInterface::SATURDAY_DELIVERY]);
            $awb->setMorningDelivery((int)$data[AwbInterface::MORNING_DELIVERY]);
            $awb->setPackageOpening((int)$data[AwbInterface::PACKAGE_OPENING]);
            $awb->setObservations(trim($data[AwbInterface::OBSERVATIONS]));
            $awb->setContent(trim($data[AwbInterface::CONTENT]));

            $this->_awbRepository->save($awb);
        } catch (NoSuchEntityException | CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect->setPath('*/*/');
        }

        $this->messageManager->addSuccessMessage(__('You saved the AWB.'));
        return $resultRedirect->setPath('*/*/edit/', ['id' => $awb->getId()]);
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
     * Method getCounty
     *
     * @param string $county
     * @return string|CountyInterface
     */
    private function getCounty(string $county)
    {
        $countyObj = $this->_countyRepository->getByName($county);
        if ($countyObj->getId()) {
            return $countyObj;
        }

        return $county;
    }

    /**
     * Method getLocality
     *
     * @param int $countyId
     * @param string $cityName
     * @return array|string
     */
    private function getLocality(int $countyId, string $cityName)
    {
        try {
            $locality = $this->_cityRepository->getByCountyIdAndCityName($countyId, $cityName);
            if (isset($locality[CityInterface::LOCALITY_ID])) {
                return $locality;
            }
            // phpcs:ignore Magento2.CodeAnalysis.EmptyBlock.DetectedCatch
        } catch (LocalizedException $e) {
        }

        return $cityName;
    }
}
