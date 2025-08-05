<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Api\Data;

/**
 * Awb Interface
 *
 * Description: Awb Structure of object.
 */
interface AwbInterface
{
    public const TABLE_NAME = 'urgent_cargus_awb';

    public const ID = 'id';
    public const ORDER_ID = 'order_id';
    public const PRINTED = 'printed';
    public const AWB_NO = 'awb_no';
    public const RETURN_CODE = 'return_code';
    public const RETURN_AWB = 'return_awb';
    public const PICKUP_LOCATION_ID = 'pickup_location_id';
    public const PUDO_ID = 'pudo_id';
    public const RECIPIENT_NAME = 'recipient_name';
    public const COUNTY_ID = 'county_id';
    public const DESTINATION_COUNTY = 'destination_county';
    public const LOCALITY_ID = 'locality_id';
    public const DESTINATION_LOCALITY = 'destination_locality';
    public const DESTINATION_ADDRESS = 'destination_address';
    public const RECIPIENT_CONTACT = 'recipient_contact';
    public const RECIPIENT_PHONE = 'recipient_phone';
    public const RECIPIENT_EMAIL = 'recipient_email';
    public const ZIP_CODE = 'zip_code';
    public const ENVELOPE = 'envelope';
    public const PARCEL = 'parcel';
    public const WEIGHT = 'weight';
    public const LENGTH = 'length';
    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const DECLARED_VALUE = 'declared_value';
    public const CASH_REFUNDS = 'cash_refunds';
    public const ACCOUNT_REFUNDS = 'account_refunds';
    public const OTHER_REPAYMENT = 'other_repayment';
    public const SHIPPING_PAYER = 'shipping_payer';
    public const SATURDAY_DELIVERY = 'saturday_delivery';
    public const MORNING_DELIVERY = 'morning_delivery';
    public const PACKAGE_OPENING = 'package_opening';
    public const OBSERVATIONS = 'observations';
    public const CONTENT = 'content';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const PRINTED_NO = 0;
    public const PRINTED_YES = 1;
    public const SHIPPING_PAYER_SENDER = 1;
    public const SHIPPING_PAYER_CONSIGNEE = 2;
    public const SATURDAY_DELIVERY_NO = 0;
    public const SATURDAY_DELIVERY_YES = 1;
    public const MORNING_DELIVERY_NO = 0;
    public const MORNING_DELIVERY_YES = 1;
    public const PACKAGE_OPENING_NO = 0;
    public const PACKAGE_OPENING_YES = 1;

    /**
     * Method getId
     *
     * @return mixed
     */
    public function getId();

    /**
     * Method getOrderId
     *
     * @return string
     */
    public function getOrderId(): string;

    /**
     * Method getPrinted
     *
     * @return int
     */
    public function getPrinted(): int;

    /**
     * Method getAwbNo
     *
     * @return string|null
     */
    public function getAwbNo(): ?string;

    /**
     * Method getReturnCode
     *
     * @return string|null
     */
    public function getReturnCode(): ?string;

    /**
     * Method getReturnAwb
     *
     * @return string|null
     */
    public function getReturnAwb(): ?string;

    /**
     * Method getPickupLocationId
     *
     * @return int
     */
    public function getPickupLocationId(): int;

    /**
     * Method getPudoId
     *
     * @return int
     */
    public function getPudoId(): int;

    /**
     * Method getRecipientName
     *
     * @return string
     */
    public function getRecipientName(): string;

    /**
     * Method getCountyId
     *
     * @return int
     */
    public function getCountyId(): int;

    /**
     * Method getDestinationCounty
     *
     * @return string
     */
    public function getDestinationCounty(): string;

    /**
     * Method getLocalityId
     *
     * @return int
     */
    public function getLocalityId(): int;

    /**
     * Method getDestinationLocality
     *
     * @return string
     */
    public function getDestinationLocality(): string;

    /**
     * Method getDestinationAddress
     *
     * @return string
     */
    public function getDestinationAddress(): string;

    /**
     * Method getRecipientContact
     *
     * @return string
     */
    public function getRecipientContact(): string;

    /**
     * Method getRecipientPhone
     *
     * @return string
     */
    public function getRecipientPhone(): string;

    /**
     * Method getRecipientEmail
     *
     * @return string
     */
    public function getRecipientEmail(): string;

    /**
     * Method getZipCode
     *
     * @return string
     */
    public function getZipCode(): string;

    /**
     * Method getEnvelope
     *
     * @return int
     */
    public function getEnvelope(): int;

    /**
     * Method getParcel
     *
     * @return int
     */
    public function getParcel(): int;

    /**
     * Method getWeight
     *
     * @return int
     */
    public function getWeight(): int;

    /**
     * Method getLength
     *
     * @return int
     */
    public function getLength(): int;

    /**
     * Method getWidth
     *
     * @return int
     */
    public function getWidth(): int;

    /**
     * Method getHeight
     *
     * @return int
     */
    public function getHeight(): int;

    /**
     * Method getDeclaredValue
     *
     * @return float
     */
    public function getDeclaredValue(): float;

    /**
     * Method getCashRefunds
     *
     * @return float
     */
    public function getCashRefunds(): float;

    /**
     * Method getAccountRefunds
     *
     * @return float
     */
    public function getAccountRefunds(): float;

    /**
     * Method getOtherRepayment
     *
     * @return string|null
     */
    public function getOtherRepayment(): ?string;

    /**
     * Method getShippingPayer
     *
     * @return int
     */
    public function getShippingPayer(): int;

    /**
     * Method getSaturdayDelivery
     *
     * @return int
     */
    public function getSaturdayDelivery(): int;

    /**
     * Method getMorningDelivery
     *
     * @return int
     */
    public function getMorningDelivery(): int;

    /**
     * Method getPackageOpening
     *
     * @return int
     */
    public function getPackageOpening(): int;

    /**
     * Method getObservations
     *
     * @return string|null
     */
    public function getObservations(): ?string;

    /**
     * Method getContent
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Method getCreatedAt
     *
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * Method getUpdatedAt
     *
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * Method setId
     *
     * @param $id
     *
     * @return mixed
     */
    public function setId($id);

    /**
     * Method setOrderId
     *
     * @param string $orderId
     *
     * @return AwbInterface
     */
    public function setOrderId(string $orderId): AwbInterface;

    /**
     * Method setPrinted
     *
     * @param int $printed
     *
     * @return AwbInterface
     */
    public function setPrinted(int $printed = self::PRINTED_NO): AwbInterface;

    /**
     * Method setAwbNo
     *
     * @param string|null $awbNo
     *
     * @return AwbInterface
     */
    public function setAwbNo(?string $awbNo): AwbInterface;

    /**
     * Method setReturnCode
     *
     * @param string|null $returnCode
     * @return AwbInterface
     */
    public function setReturnCode(?string $returnCode): AwbInterface;

    /**
     * Method setReturnAwb
     *
     * @param string|null $returnAwb
     * @return AwbInterface
     */
    public function setReturnAwb(?string $returnAwb): AwbInterface;

    /**
     * Method setPickupLocationId
     *
     * @param int $pickupLocationId
     *
     * @return AwbInterface
     */
    public function setPickupLocationId(int $pickupLocationId): AwbInterface;

    /**
     * Method setPudoId
     *
     * @param int $pudoId
     *
     * @return AwbInterface
     */
    public function setPudoId(int $pudoId = 0): AwbInterface;

    /**
     * Method setRecipientName
     *
     * @param string $recipientName
     *
     * @return AwbInterface
     */
    public function setRecipientName(string $recipientName): AwbInterface;

    /**
     * Method setCountyId
     *
     * @param int $countyId
     *
     * @return AwbInterface
     */
    public function setCountyId(int $countyId): AwbInterface;

    /**
     * Method setDestinationCounty
     *
     * @param string $destinationCounty
     *
     * @return AwbInterface
     */
    public function setDestinationCounty(string $destinationCounty): AwbInterface;

    /**
     * Method setLocalityId
     *
     * @param int $localityId
     *
     * @return AwbInterface
     */
    public function setLocalityId(int $localityId): AwbInterface;

    /**
     * Method setDestinationLocality
     *
     * @param string $destinationLocality
     *
     * @return AwbInterface
     */
    public function setDestinationLocality(string $destinationLocality): AwbInterface;

    /**
     * Method setDestinationAddress
     *
     * @param string $destinationAddress
     *
     * @return AwbInterface
     */
    public function setDestinationAddress(string $destinationAddress): AwbInterface;

    /**
     * Method setRecipientContact
     *
     * @param string $recipientContact
     *
     * @return AwbInterface
     */
    public function setRecipientContact(string $recipientContact): AwbInterface;

    /**
     * Method setRecipientPhone
     *
     * @param string $recipientPhone
     *
     * @return AwbInterface
     */
    public function setRecipientPhone(string $recipientPhone): AwbInterface;

    /**
     * Method setRecipientEmail
     *
     * @param string $recipientEmail
     *
     * @return AwbInterface
     */
    public function setRecipientEmail(string $recipientEmail): AwbInterface;

    /**
     * Method setZipCode
     *
     * @param string $zipCode
     *
     * @return AwbInterface
     */
    public function setZipCode(string $zipCode): AwbInterface;

    /**
     * Method setEnvelope
     *
     * @param int $envelope
     *
     * @return AwbInterface
     */
    public function setEnvelope(int $envelope = 0): AwbInterface;

    /**
     * Method setParcel
     *
     * @param int $parcel
     *
     * @return AwbInterface
     */
    public function setParcel(int $parcel = 0): AwbInterface;

    /**
     * Method setWeight
     *
     * @param int $weight
     *
     * @return AwbInterface
     */
    public function setWeight(int $weight = 0): AwbInterface;

    /**
     * Method setLength
     *
     * @param int $length
     *
     * @return AwbInterface
     */
    public function setLength(int $length = 0): AwbInterface;

    /**
     * Method setWidth
     *
     * @param int $width
     *
     * @return AwbInterface
     */
    public function setWidth(int $width = 0): AwbInterface;

    /**
     * Method setHeight
     *
     * @param int $height
     *
     * @return AwbInterface
     */
    public function setHeight(int $height = 0): AwbInterface;

    /**
     * Method setDeclaredValue
     *
     * @param float $declaredValue
     *
     * @return AwbInterface
     */
    public function setDeclaredValue(float $declaredValue): AwbInterface;

    /**
     * Method setCashRefunds
     *
     * @param float $cashRefunds
     *
     * @return AwbInterface
     */
    public function setCashRefunds(float $cashRefunds): AwbInterface;

    /**
     * Method setAccountRefunds
     *
     * @param float $accountRefunds
     *
     * @return AwbInterface
     */
    public function setAccountRefunds(float $accountRefunds): AwbInterface;

    /**
     * Method setOtherRepayment
     *
     * @param string|null $orderRepayment
     *
     * @return AwbInterface
     */
    public function setOtherRepayment(?string $orderRepayment): AwbInterface;

    /**
     * Method setShippingPayer
     *
     * @param int $shippingPayer
     *
     * @return AwbInterface
     */
    public function setShippingPayer(int $shippingPayer): AwbInterface;

    /**
     * Method setSaturdayDelivery
     *
     * @param int $saturdayDelivery
     *
     * @return AwbInterface
     */
    public function setSaturdayDelivery(int $saturdayDelivery = self::SATURDAY_DELIVERY_NO): AwbInterface;

    /**
     * Method setMorningDelivery
     *
     * @param int $morningDelivery
     *
     * @return AwbInterface
     */
    public function setMorningDelivery(int $morningDelivery = self::MORNING_DELIVERY_NO): AwbInterface;

    /**
     * Method setPackageOpening
     *
     * @param int $packageOpening
     *
     * @return AwbInterface
     */
    public function setPackageOpening(int $packageOpening = self::PACKAGE_OPENING_NO): AwbInterface;

    /**
     * Method setObservations
     *
     * @param string|null $observations
     *
     * @return AwbInterface
     */
    public function setObservations(?string $observations): AwbInterface;

    /**
     * Method setContent
     *
     * @param string $content
     *
     * @return AwbInterface
     */
    public function setContent(string $content): AwbInterface;

    /**
     * Method setCreatedAt
     *
     * @param string $createdAt
     *
     * @return AwbInterface
     */
    public function setCreatedAt(string $createdAt): AwbInterface;

    /**
     * Method setUpdatedAt
     *
     * @param string $updatedAt
     *
     * @return AwbInterface
     */
    public function setUpdatedAt(string $updatedAt): AwbInterface;
}
