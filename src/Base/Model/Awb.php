<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Magento\Framework\Model\AbstractModel;
use Urgent\Base\Api\Data\AwbInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Awb
 *
 * Description class.
 */
class Awb extends AbstractModel implements AwbInterface, IdentityInterface
{
    protected $_cacheTag = AwbInterface::TABLE_NAME;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Awb::class);
    }

    /**
     * Method getIdentities
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [AwbInterface::TABLE_NAME . '_' . $this->getId()];
    }

    /**
     * Method getId
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(AwbInterface::ID);
    }

    /**
     * Method getOrderId
     *
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->getData(AwbInterface::ORDER_ID);
    }

    /**
     * Method getPrinted
     *
     * @return int
     */
    public function getPrinted(): int
    {
        return $this->getData(AwbInterface::PRINTED);
    }

    /**
     * Method getAwbNo
     *
     * @return string|null
     */
    public function getAwbNo(): ?string
    {
        return $this->getData(AwbInterface::AWB_NO);
    }

    /**
     * Method getReturnCode
     *
     * @return string|null
     */
    public function getReturnCode(): ?string
    {
        return $this->getData(AwbInterface::RETURN_CODE);
    }

    /**
     * Method getReturnAwb
     *
     * @return string|null
     */
    public function getReturnAwb(): ?string
    {
        return $this->getData(AwbInterface::RETURN_AWB);
    }

    /**
     * Method getPickupLocationId
     *
     * @return int
     */
    public function getPickupLocationId(): int
    {
        return (int)$this->getData(AwbInterface::PICKUP_LOCATION_ID);
    }

    /**
     * Method getPudoId
     *
     * @return int
     */
    public function getPudoId(): int
    {
        return (int)$this->getData(AwbInterface::PUDO_ID);
    }

    /**
     * Method getRecipientName
     *
     * @return string
     */
    public function getRecipientName(): string
    {
        return $this->getData(AwbInterface::RECIPIENT_NAME);
    }

    /**
     * Method getCountyId
     *
     * @return int
     */
    public function getCountyId(): int
    {
        return $this->getData(AwbInterface::COUNTY_ID);
    }

    /**
     * Method getDestinationCounty
     *
     * @return string
     */
    public function getDestinationCounty(): string
    {
        return $this->getData(AwbInterface::DESTINATION_COUNTY);
    }

    /**
     * Method getLocalityId
     *
     * @return int
     */
    public function getLocalityId(): int
    {
        return $this->getData(AwbInterface::LOCALITY_ID);
    }

    /**
     * Method getDestinationLocality
     *
     * @return string
     */
    public function getDestinationLocality(): string
    {
        return $this->getData(AwbInterface::DESTINATION_LOCALITY);
    }

    /**
     * Method getDestinationAddress
     *
     * @return string
     */
    public function getDestinationAddress(): string
    {
        return $this->getData(AwbInterface::DESTINATION_ADDRESS);
    }

    /**
     * Method getRecipientContact
     *
     * @return string
     */
    public function getRecipientContact(): string
    {
        return $this->getData(AwbInterface::RECIPIENT_CONTACT);
    }

    /**
     * Method getRecipientPhone
     *
     * @return string
     */
    public function getRecipientPhone(): string
    {
        return $this->getData(AwbInterface::RECIPIENT_PHONE);
    }

    /**
     * Method getRecipientEmail
     *
     * @return string
     */
    public function getRecipientEmail(): string
    {
        return $this->getData(AwbInterface::RECIPIENT_EMAIL);
    }

    /**
     * Method getZipCode
     *
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->getData(AwbInterface::ZIP_CODE);
    }

    /**
     * Method getEnvelope
     *
     * @return int
     */
    public function getEnvelope(): int
    {
        return (int)$this->getData(AwbInterface::ENVELOPE);
    }

    /**
     * Method getParcel
     *
     * @return int
     */
    public function getParcel(): int
    {
        return (int)$this->getData(AwbInterface::PARCEL);
    }

    /**
     * Method getWeight
     *
     * @return int
     */
    public function getWeight(): int
    {
        return (int)$this->getData(AwbInterface::WEIGHT);
    }

    /**
     * Method getLength
     *
     * @return int
     */
    public function getLength(): int
    {
        return (int)$this->getData(AwbInterface::LENGTH);
    }

    /**
     * Method getWidth
     *
     * @return int
     */
    public function getWidth(): int
    {
        return (int)$this->getData(AwbInterface::WIDTH);
    }

    /**
     * Method getHeight
     *
     * @return int
     */
    public function getHeight(): int
    {
        return (int)$this->getData(AwbInterface::HEIGHT);
    }

    /**
     * Method getDeclaredValue
     *
     * @return float
     */
    public function getDeclaredValue(): float
    {
        return (float)$this->getData(AwbInterface::DECLARED_VALUE);
    }

    /**
     * Method getCashRefunds
     *
     * @return float
     */
    public function getCashRefunds(): float
    {
        return (float)$this->getData(AwbInterface::CASH_REFUNDS);
    }

    /**
     * Method getAccountRefunds
     *
     * @return float
     */
    public function getAccountRefunds(): float
    {
        return (float)$this->getData(AwbInterface::ACCOUNT_REFUNDS);
    }

    /**
     * Method getOtherRepayment
     *
     * @return string|null
     */
    public function getOtherRepayment(): ?string
    {
        return $this->getData(AwbInterface::OTHER_REPAYMENT);
    }

    /**
     * Method getShippingPayer
     *
     * @return int
     */
    public function getShippingPayer(): int
    {
        return (int)$this->getData(AwbInterface::SHIPPING_PAYER);
    }

    /**
     * Method getSaturdayDelivery
     *
     * @return int
     */
    public function getSaturdayDelivery(): int
    {
        return (int)$this->getData(AwbInterface::SATURDAY_DELIVERY);
    }

    /**
     * Method getMorningDelivery
     *
     * @return int
     */
    public function getMorningDelivery(): int
    {
        return (int)$this->getData(AwbInterface::MORNING_DELIVERY);
    }

    /**
     * Method getPackageOpening
     *
     * @return int
     */
    public function getPackageOpening(): int
    {
        return (int)$this->getData(AwbInterface::PACKAGE_OPENING);
    }

    /**
     * Method getObservations
     *
     * @return string|null
     */
    public function getObservations(): ?string
    {
        return $this->getData(AwbInterface::OBSERVATIONS);
    }

    /**
     * Method getContent
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->getData(AwbInterface::CONTENT);
    }

    /**
     * Method getCreatedAt
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(AwbInterface::CREATED_AT);
    }

    /**
     * Method getUpdatedAt
     *
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(AwbInterface::UPDATED_AT);
    }

    /**
     * Method setId
     *
     * @param $id
     *
     * @return mixed|Awb
     */
    public function setId($id)
    {
        return $this->setData(AwbInterface::ID, $id);
    }

    /**
     * Method setOrderId
     *
     * @param string $orderId
     *
     * @return AwbInterface
     */
    public function setOrderId(string $orderId): AwbInterface
    {
        return $this->setData(AwbInterface::ORDER_ID, $orderId);
    }

    /**
     * Method setPrinted
     *
     * @param int $printed
     *
     * @return AwbInterface
     */
    public function setPrinted(int $printed = self::PRINTED_NO): AwbInterface
    {
        return $this->setData(AwbInterface::PRINTED, $printed);
    }

    /**
     * Method setAwbNo
     *
     * @param string|null $awbNo
     *
     * @return AwbInterface
     */
    public function setAwbNo(?string $awbNo): AwbInterface
    {
        return $this->setData(AwbInterface::AWB_NO, $awbNo);
    }

    /**
     * Method setReturnCode
     *
     * @param string|null $returnCode
     * @return AwbInterface
     */
    public function setReturnCode(?string $returnCode): AwbInterface
    {
        return $this->setData(AwbInterface::RETURN_CODE, $returnCode);
    }

    /**
     * Method setReturnAwb
     *
     * @param string|null $returnAwb
     * @return AwbInterface
     */
    public function setReturnAwb(?string $returnAwb): AwbInterface
    {
        return $this->setData(AwbInterface::RETURN_AWB, $returnAwb);
    }

    /**
     * Method setPickupLocationId
     *
     * @param int $pickupLocationId
     *
     * @return AwbInterface
     */
    public function setPickupLocationId(int $pickupLocationId): AwbInterface
    {
        return $this->setData(AwbInterface::PICKUP_LOCATION_ID, $pickupLocationId);
    }

    /**
     * Method setPudoId
     *
     * @param int $pudoId
     *
     * @return AwbInterface
     */
    public function setPudoId(int $pudoId = 0): AwbInterface
    {
        return $this->setData(AwbInterface::PUDO_ID, $pudoId);
    }

    /**
     * Method setRecipientName
     *
     * @param string $recipientName
     *
     * @return AwbInterface
     */
    public function setRecipientName(string $recipientName): AwbInterface
    {
        return $this->setData(AwbInterface::RECIPIENT_NAME, $recipientName);
    }

    /**
     * Method setCountyId
     *
     * @param int $countyId
     *
     * @return AwbInterface
     */
    public function setCountyId(int $countyId): AwbInterface
    {
        return $this->setData(AwbInterface::COUNTY_ID, $countyId);
    }

    /**
     * Method setDestinationCounty
     *
     * @param string $destinationCounty
     *
     * @return AwbInterface
     */
    public function setDestinationCounty(string $destinationCounty): AwbInterface
    {
        return $this->setData(AwbInterface::DESTINATION_COUNTY, $destinationCounty);
    }

    /**
     * Method setLocalityId
     *
     * @param int $localityId
     *
     * @return AwbInterface
     */
    public function setLocalityId(int $localityId): AwbInterface
    {
        return $this->setData(AwbInterface::LOCALITY_ID, $localityId);
    }

    /**
     * Method setDestinationLocality
     *
     * @param string $destinationLocality
     *
     * @return AwbInterface
     */
    public function setDestinationLocality(string $destinationLocality): AwbInterface
    {
        return $this->setData(AwbInterface::DESTINATION_LOCALITY, $destinationLocality);
    }

    /**
     * Method setDestinationAddress
     *
     * @param string $destinationAddress
     *
     * @return AwbInterface
     */
    public function setDestinationAddress(string $destinationAddress): AwbInterface
    {
        return $this->setData(AwbInterface::DESTINATION_ADDRESS, $destinationAddress);
    }

    /**
     * Method setRecipientContact
     *
     * @param string $recipientContact
     *
     * @return AwbInterface
     */
    public function setRecipientContact(string $recipientContact): AwbInterface
    {
        return $this->setData(AwbInterface::RECIPIENT_CONTACT, $recipientContact);
    }

    /**
     * Method setRecipientPhone
     *
     * @param string $recipientPhone
     *
     * @return AwbInterface
     */
    public function setRecipientPhone(string $recipientPhone): AwbInterface
    {
        return $this->setData(AwbInterface::RECIPIENT_PHONE, $recipientPhone);
    }

    /**
     * Method setRecipientEmail
     *
     * @param string $recipientEmail
     *
     * @return AwbInterface
     */
    public function setRecipientEmail(string $recipientEmail): AwbInterface
    {
        return $this->setData(AwbInterface::RECIPIENT_EMAIL, $recipientEmail);
    }

    /**
     * Method setZipCode
     *
     * @param string $zipCode
     *
     * @return AwbInterface
     */
    public function setZipCode(string $zipCode): AwbInterface
    {
        return $this->setData(AwbInterface::ZIP_CODE, $zipCode);
    }

    /**
     * Method setEnvelope
     *
     * @param int $envelope
     *
     * @return AwbInterface
     */
    public function setEnvelope(int $envelope = 0): AwbInterface
    {
        return $this->setData(AwbInterface::ENVELOPE, $envelope);
    }

    /**
     * Method setParcel
     *
     * @param int $parcel
     *
     * @return AwbInterface
     */
    public function setParcel(int $parcel = 0): AwbInterface
    {
        return $this->setData(AwbInterface::PARCEL, $parcel);
    }

    /**
     * Method setWeight
     *
     * @param int $weight
     *
     * @return AwbInterface
     */
    public function setWeight(int $weight = 0): AwbInterface
    {
        return $this->setData(AwbInterface::WEIGHT, $weight);
    }

    /**
     * Method setLength
     *
     * @param int $length
     *
     * @return AwbInterface
     */
    public function setLength(int $length = 0): AwbInterface
    {
        return $this->setData(AwbInterface::LENGTH, $length);
    }

    /**
     * Method setWidth
     *
     * @param int $width
     *
     * @return AwbInterface
     */
    public function setWidth(int $width = 0): AwbInterface
    {
        return $this->setData(AwbInterface::WIDTH, $width);
    }

    /**
     * Method setHeight
     *
     * @param int $height
     *
     * @return AwbInterface
     */
    public function setHeight(int $height = 0): AwbInterface
    {
        return $this->setData(AwbInterface::HEIGHT, $height);
    }

    /**
     * Method setDeclaredValue
     *
     * @param float $declaredValue
     *
     * @return AwbInterface
     */
    public function setDeclaredValue(float $declaredValue): AwbInterface
    {
        return $this->setData(AwbInterface::DECLARED_VALUE, $declaredValue);
    }

    /**
     * Method setCashRefunds
     *
     * @param float $cashRefunds
     *
     * @return AwbInterface
     */
    public function setCashRefunds(float $cashRefunds): AwbInterface
    {
        return $this->setData(AwbInterface::CASH_REFUNDS, $cashRefunds);
    }

    /**
     * Method setAccountRefunds
     *
     * @param float $accountRefunds
     *
     * @return AwbInterface
     */
    public function setAccountRefunds(float $accountRefunds): AwbInterface
    {
        return $this->setData(AwbInterface::ACCOUNT_REFUNDS, $accountRefunds);
    }

    /**
     * Method setOtherRepayment
     *
     * @param string|null $orderRepayment
     *
     * @return AwbInterface
     */
    public function setOtherRepayment(?string $orderRepayment): AwbInterface
    {
        return $this->setData(AwbInterface::OTHER_REPAYMENT, $orderRepayment);
    }

    /**
     * Method setShippingPayer
     *
     * @param int $shippingPayer
     *
     * @return AwbInterface
     */
    public function setShippingPayer(int $shippingPayer): AwbInterface
    {
        return $this->setData(AwbInterface::SHIPPING_PAYER, $shippingPayer);
    }

    /**
     * Method setSaturdayDelivery
     *
     * @param int $saturdayDelivery
     *
     * @return AwbInterface
     */
    public function setSaturdayDelivery(int $saturdayDelivery = self::SATURDAY_DELIVERY_NO): AwbInterface
    {
        return $this->setData(AwbInterface::SATURDAY_DELIVERY, $saturdayDelivery);
    }

    /**
     * Method setMorningDelivery
     *
     * @param int $morningDelivery
     *
     * @return AwbInterface
     */
    public function setMorningDelivery(int $morningDelivery = self::MORNING_DELIVERY_NO): AwbInterface
    {
        return $this->setData(AwbInterface::MORNING_DELIVERY, $morningDelivery);
    }

    /**
     * Method setPackageOpening
     *
     * @param int $packageOpening
     *
     * @return AwbInterface
     */
    public function setPackageOpening(int $packageOpening = self::PACKAGE_OPENING_NO): AwbInterface
    {
        return $this->setData(AwbInterface::PACKAGE_OPENING, $packageOpening);
    }

    /**
     * Method setObservations
     *
     * @param string|null $observations
     *
     * @return AwbInterface
     */
    public function setObservations(?string $observations): AwbInterface
    {
        return $this->setData(AwbInterface::OBSERVATIONS, $observations);
    }

    /**
     * Method setContent
     *
     * @param string $content
     *
     * @return AwbInterface
     */
    public function setContent(string $content): AwbInterface
    {
        return $this->setData(AwbInterface::CONTENT, $content);
    }

    /**
     * Method setCreatedAt
     *
     * @param string $createdAt
     *
     * @return AwbInterface
     */
    public function setCreatedAt(string $createdAt): AwbInterface
    {
        return $this->setData(AwbInterface::CREATED_AT, $createdAt);
    }

    /**
     * Method setUpdatedAt
     *
     * @param string $updatedAt
     *
     * @return AwbInterface
     */
    public function setUpdatedAt(string $updatedAt): AwbInterface
    {
        return $this->setData(AwbInterface::UPDATED_AT, $updatedAt);
    }
}
