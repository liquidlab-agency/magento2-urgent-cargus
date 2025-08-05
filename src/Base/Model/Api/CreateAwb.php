<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 25.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Api;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\HTTP\LaminasClientFactory;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Urgent\Base\Api\Data\TokenInterfaceFactory;
use Urgent\Base\Api\Data\AwbInterface;
use Urgent\Base\Api\TokenRepositoryInterface;
use Urgent\Base\Logger\Logger;
use Urgent\Base\Model\Config\Config;
use Urgent\Base\Model\Helper\IntlCountryId;
use Magento\Sales\Api\Data\OrderInterface;
use Urgent\Base\Model\ResourceModel\Token\Collection as TokenCollection;
use Laminas\Http\Request;
use Laminas\Http\Exception\RuntimeException as LaminasHttpException;

/**
 * Class CreateAwb
 *
 * Description: ...
 */
class CreateAwb extends Cargus
{
    protected const CREATE_AWB = 'Awbs/WithGetAwb';
    protected const CREATE_AWB_V4 = 'awb';
    protected const AWB_DETAILS = 'awbs';
    protected const RO_STORE_CURRENCY = 'RON';

    /** @var AwbInterface $_awbData */
    protected AwbInterface $_awbData;

    /** @var IntlCountryId $intlCountryId */
    protected IntlCountryId $intlCountryId;

    /** @var OrderInterface $order */
    protected OrderInterface $order;

    /**
     * Constructor
     *
     * @param Logger $logger
     * @param Config $config
     * @param LaminasClientFactory $laminasClientFactory
     * @param TokenCollection $tokenCollection
     * @param TimezoneInterface $timezone
     * @param TokenInterfaceFactory $tokenFactory
     * @param TokenRepositoryInterface $tokenRepository
     * @param SerializerInterface $serializer
     * @param DirectoryList $directoryList
     * @param EncryptorInterface $encryptor
     * @param IntlCountryId $intlCountryId
     * @param OrderInterface $order
     */
    public function __construct(
        Logger $logger,
        Config $config,
        LaminasClientFactory $laminasClientFactory,
        TokenCollection $tokenCollection,
        TimezoneInterface $timezone,
        TokenInterfaceFactory $tokenFactory,
        TokenRepositoryInterface $tokenRepository,
        SerializerInterface $serializer,
        DirectoryList $directoryList,
        EncryptorInterface $encryptor,
        IntlCountryId $intlCountryId,
        OrderInterface $order
    ) {
        $this->intlCountryId = $intlCountryId;
        $this->order = $order;
        parent::__construct(
            $logger,
            $config,
            $laminasClientFactory,
            $tokenCollection,
            $timezone,
            $tokenFactory,
            $tokenRepository,
            $serializer,
            $directoryList,
            $encryptor
        );
    }

    /**
     * Method addAwbData
     *
     * @param AwbInterface $awb
     * @return $this
     */
    public function addAwbData(AwbInterface $awb): CreateAwb
    {
        $this->_awbData = $awb;
        return $this;
    }

    /**
     * Method execute
     */
    public function execute()
    {
        if ($this->_config->getApiIsActive()) {
            $client = $this->getClient(Request::METHOD_POST);
            try {
                $orderCurrencyCode = $this->getOrderCurrencyCode();
                if(empty($orderCurrencyCode))
                {
                    return [];
                }

                $token = $this->login();
                $client->setHeaders(['Authorization' => 'Bearer ' . $token]);
                if($orderCurrencyCode !== $this::RO_STORE_CURRENCY){
                    $intlCountryId = $this->intlCountryId->getIntlCountryIdByCurrency($orderCurrencyCode);
                    if (!$intlCountryId) {
                        return [];
                    }
                    $client->setUri($this->_config->getApiUrlV4() . self::CREATE_AWB_V4);
                    $client->setRawBody($this->getExternalAwbData((int)$intlCountryId));
                } else {
                    $client->setUri($this->_config->getApiUrl() . self::CREATE_AWB);
                    $client->setRawBody($this->getAwbData());
                }
                $request = $this->doRequest($client);
                if ($request['success']) {
                    if($orderCurrencyCode !== $this::RO_STORE_CURRENCY){
                        if(!empty($request["body"])){
                            //scenario for external shipments, where we receive just the awb nr, and we need to fetch
                            //the rest of the awb details will be fetched with an extra api call
                            return $this->getAwbDetails($request["body"]);
                        }
                    }
                    //scenario for internal shipments
                    return $this->_serializer->unserialize($request["body"]);
                }
                return $request;
            } catch (LaminasHttpException|CouldNotSaveException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->critical($e->getMessage());
                }
            }
        }
        return [];
    }

    /**
     * Method getAwbData
     *
     * @return string
     */
    private function getAwbData(): string
    {

        $fields = [];

        // Sender Data
        $fields['Sender'] = [
            'LocationId' => (string)$this->_awbData->getPickupLocationId()
        ];

        // Recipient Data
        $fields['Recipient'] = [
            'LocationId' => null,
            'Name' => $this->_awbData->getRecipientName(),
            'CountyId' => null,
            'CountyName' => $this->_awbData->getDestinationCounty(),
            'LocalityId' => null,
            'LocalityName' => $this->_awbData->getDestinationLocality(),
            'StreetId' => null,
            'StreetName' => '-',
            'AddressText' => $this->_awbData->getDestinationAddress(),
            'ContactPerson' => $this->_awbData->getRecipientContact(),
            'PhoneNumber' => $this->_awbData->getRecipientPhone(),
            'Email' => $this->_awbData->getRecipientEmail(),
            'CodPostal' => $this->_awbData->getZipCode(),
        ];

        // AWB Data
        $fields['Parcels'] = $this->_awbData->getParcel();
        $fields['Envelopes'] = $this->_awbData->getEnvelope();
        $fields['TotalWeight'] = $this->_awbData->getWeight();
        $fields['DeclaredValue'] = $this->_awbData->getDeclaredValue();
        $fields['CashRepayment'] = $this->_awbData->getCashRefunds();
        $fields['BankRepayment'] = $this->_awbData->getAccountRefunds();
        $fields['OtherRepayment'] = (string)$this->_awbData->getOtherRepayment();
        $fields['OpenPackage'] = $this->_awbData->getPackageOpening() === 1;
        $fields['PriceTableId'] = $this->_config->getGeneralPriceTable($this->getStoreIdByOrder());
        $fields['ShipmentPayer'] = $this->_awbData->getShippingPayer();
        $fields['MorningDelivery'] = $this->_awbData->getMorningDelivery() === 1;
        $fields['SaturdayDelivery'] = $this->_awbData->getSaturdayDelivery() === 1;
        $fields['Observations'] = (string)$this->_awbData->getObservations();
        $fields['PackageContent'] = $this->_awbData->getContent();
        $fields['CustomString'] = $this->_awbData->getOrderId();
        $fields['ParcelCodes'] = [
            [
                "Code" => 0,
                "Type" => $this->_awbData->getParcel() > 0 ? 1 : 0,
                "Weight" => $this->_awbData->getWeight(),
                "Length" => $this->_awbData->getLength(),
                "Width" => $this->_awbData->getWidth(),
                "Height" => $this->_awbData->getHeight(),
                "ParcelContent" => $this->_awbData->getContent()
            ]
        ];

        // Add Pudo ID if exists
        if ($this->_awbData->getPudoId()) {
            $fields['DeliveryPudoPoint'] = $this->_awbData->getPudoId();
            $fields['ServiceId'] = 38;
        }

        // Consumer Return
        $consumerReturn = $this->_config->getGeneralConsumerReturn();
        $fields['ConsumerReturnType'] = $consumerReturn;
        $fields['ReturnCodeExpirationDays'] = $consumerReturn > 0 ? $this->_config->getGeneralConsumerReturnDays() : 0;

        $fields = $this->_serializer->serialize($fields);
        if ($this->_config->getDebugLogger()) {
            $this->_logger->info($fields);
        }

        return $fields;
    }

    /**
     * @param int $intlCountryId
     * @return string
     */
    private function getExternalAwbData(int $intlCountryId): string
    {
        $fields = [];

        // Sender Data
        $fields['sender'] = [
            'pickupLocationId' => (string)$this->_awbData->getPickupLocationId(),
            'name' => "string",
            'contactPerson' => "string",
            'countyId' => 0,
            'countyName' => "string",
            'localityId' => 0,
            'localityName' => "string",
            'streetId' => 0,
            'streetName' => "string",
            'buildingNumber' => "string",
            'addressText' => "string",
            'phoneNumber' => "string",
            'email' => "string",
            'zipCode' => "string",
            'countryId' => 1
        ];

        // Recipient Data
        $fields['recipient'] = [
            'pickupLocationId' => 0,
            'name' => $this->_awbData->getRecipientName(),
            'contactPerson' => $this->_awbData->getRecipientContact(),
            'countyId' => 0,
            'countyName' => $this->_awbData->getDestinationCounty(),
            'localityId' => 0,
            'localityName' => $this->_awbData->getDestinationLocality(),
            'streetId' => 0,
            'streetName' => $this->_awbData->getDestinationAddress(),
            'buildingNumber' => ' ',
            'addressText' => $this->_awbData->getDestinationAddress(),
            'phoneNumber' => $this->_awbData->getRecipientPhone(),
            'email' => $this->_awbData->getRecipientEmail(),
            'zipCode' => $this->_awbData->getZipCode(),
            'countryId' => $intlCountryId
        ];

        // AWB Data
        $fields['barcode'] = '';
        $fields['parcels'] = $this->_awbData->getParcel();
        $fields['envelopes'] = $this->_awbData->getEnvelope();
        $fields['serviceId'] = 41; //static value for external shipments
        $fields['priceTableId'] = $this->_config->getGeneralPriceTable($this->getStoreIdByOrder());
        $fields['declaredValue'] = $this->_awbData->getDeclaredValue();
        $fields['cashRepayment'] = $this->_awbData->getCashRefunds();
        $fields['bankRepayment'] = $this->_awbData->getAccountRefunds();
        $fields['hasTertReimbursement'] = false;
        $fields['saturdayDelivery'] = $this->_awbData->getSaturdayDelivery() === 1;
        $fields['openPackage'] = $this->_awbData->getPackageOpening() === 1;
        $fields['shipmentPayer'] = 1;
        $fields['codPayer'] =  2; //static value for external shipments
        $fields['thirdPartyClientId'] = 1;
        $fields['thirdPartyLocationId'] = 0;
        $fields['observations'] = (string)$this->_awbData->getObservations();
        $fields['packageContent'] = $this->_awbData->getContent();
        $fields['customString'] = $this->_awbData->getOrderId();
        $fields['senderReference1'] = '';
        $fields['recipientReference1'] = '';
        $fields['recipientReference2'] = '';
        $fields['invoiceReference'] = '';
        $fields['ParcelCodes'] = [
            [
                'code' => '0',
                'type' => $this->_awbData->getParcel() > 0 ? 1 : 0,
                'weight' => $this->_awbData->getWeight(),
                'length' => $this->_awbData->getLength(),
                'width' => $this->_awbData->getWidth(),
                'height' => $this->_awbData->getHeight(),
                'parcelContent' => $this->_awbData->getContent()
            ]
        ];

        $fields = $this->_serializer->serialize($fields);
        if ($this->_config->getDebugLogger()) {
            $this->_logger->info($fields);
        }

        return $fields;
    }

    /**
     * @return string|null
     */
    private function getOrderCurrencyCode(): ?string
    {
        $orderIncrementId = $this->_awbData->getData('order_id');
        if (empty($orderIncrementId)) {
            return null;
        }

        $order = $this->order->loadByIncrementId($orderIncrementId);

        if ($order && $order->getOrderCurrencyCode()) {
            return $order->getOrderCurrencyCode();
        } else {
            return null;
        }
    }

    /**
     * @return string|null
     */
    private function getStoreIdByOrder(): ?string
    {
        $orderIncrementId = $this->_awbData->getData('order_id');
        if (empty($orderIncrementId)) {
            return null;
        }

        $order = $this->order->loadByIncrementId($orderIncrementId);

        if ($order && $order->getStoreId()) {
            return $order->getStoreId();
        } else {
            return null;
        }
    }

    /**
     * @param $barcode
     * @return array
     */
    private function getAwbDetails($barcode = null): array
    {
        $pattern = '/"(?:[^"]|"")+"/';
        if (preg_match($pattern, $barcode)) {
            //remove the outer quotes from the body value
            $barcode = trim($barcode, '"');
        }
        $client = $this->getClient(Request::METHOD_GET);
        try {
            $token = $this->login();
            $client->setHeaders(['Authorization' => 'Bearer ' . $token]);
            $client->setUri($this->_config->getApiUrl() . self::AWB_DETAILS);
            $client->setParameterGet(['barCode' => $barcode]);
            $request = $this->doRequest($client);
            if ($request['success']) {
                if (!empty($request["body"])) {
                    return $this->_serializer->unserialize($request["body"]);
                }
            }
        } catch (LaminasHttpException|CouldNotSaveException $e) {
            if ($this->_config->getDebugLogger()) {
                $this->_logger->critical($e->getMessage());
            }
        }
        return [];
    }
}
