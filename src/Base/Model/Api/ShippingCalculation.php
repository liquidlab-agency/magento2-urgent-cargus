<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 17.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Api;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Urgent\Base\Api\Data\TokenInterfaceFactory;
use Urgent\Base\Api\TokenRepositoryInterface;
use Urgent\Base\Logger\Logger;
use Urgent\Base\Model\Config\Config;
use Urgent\Base\Model\Helper\PrepareData;
use Magento\Store\Model\StoreManagerInterface;
use Urgent\Base\Model\ResourceModel\Token\Collection as TokenCollection;
use Magento\Framework\HTTP\AsyncClient\Request;
use Magento\Framework\App\ProductMetadata;
use Magento\Analytics\Model\Connector\Http\Client\Curl;
use Magento\Framework\DataObjectFactory;

/**
 * Class ShippingCalculation
 *
 * Description class.
 */
class ShippingCalculation extends Cargus
{
    protected const SHIPPING_CALCULATION = 'ShippingCalculation';
    protected const SHIPPING_CALCULATION_V4 = 'pricing/calculate';
    protected const RO_STORE_CURRENCY = 'RON';

    /** @var PrepareData $_prepareData */
    private PrepareData $_prepareData;

    /** @var StoreManagerInterface $storeManager */
    private StoreManagerInterface $storeManager;

    /**
     * Constructor
     *
     * @param Logger $logger
     * @param Config $config
     * @param TokenCollection $tokenCollection
     * @param TimezoneInterface $timezone
     * @param TokenInterfaceFactory $tokenFactory
     * @param TokenRepositoryInterface $tokenRepository
     * @param SerializerInterface $serializer
     * @param DirectoryList $directoryList
     * @param EncryptorInterface $encryptor
     * @param PrepareData $prepareData
     * @param StoreManagerInterface $storeManager
     * @param ProductMetadata $productMetadata
     * @param Curl $curl
     * @param DataObjectFactory $dataObjectFactory
     */
    public function __construct(
        Logger $logger,
        Config $config,
        TokenCollection $tokenCollection,
        TimezoneInterface $timezone,
        TokenInterfaceFactory $tokenFactory,
        TokenRepositoryInterface $tokenRepository,
        SerializerInterface $serializer,
        DirectoryList $directoryList,
        EncryptorInterface $encryptor,
        PrepareData $prepareData,
        StoreManagerInterface $storeManager,
        ProductMetadata $productMetadata,
        Curl $curl,
        DataObjectFactory $dataObjectFactory
    ) {
        $this->_prepareData = $prepareData;
        $this->storeManager = $storeManager;
        parent::__construct(
            $logger,
            $config,
            $tokenCollection,
            $timezone,
            $tokenFactory,
            $tokenRepository,
            $serializer,
            $directoryList,
            $encryptor,
            $productMetadata,
            $curl,
            $dataObjectFactory
        );
    }

    /**
     * Method execute
     *
     * @return mixed
     */
    public function execute(): array
    {
        if ($this->_config->getApiIsActive()) {

            try {
                $storeCurrencyCode = $this->storeManager->getStore()->getCurrentCurrencyCode();
            } catch (\Exception $e) {
                $this->_logger->info('Shipping Calculation. No currency code found for store.' . $e->getMessage());
                return [];
            }

            if ($storeCurrencyCode !== $this::RO_STORE_CURRENCY) {
                $data = $this->_prepareData->externalShippingCalcData();
            } else {
                $data = $this->_prepareData->shippingCalcData();
            }
            if (count($data) === 0) {
                return [];
            }
            $client = $this->getClient(Request::METHOD_POST);
            try {
                $token = $this->login();
                $client->setHeaders(['Authorization' => 'Bearer ' . $token]);

                if ($storeCurrencyCode !== $this::RO_STORE_CURRENCY) {
                    //scenario for external shipments
                    $apiUrl = $this->_config->getApiUrlV4() . self::SHIPPING_CALCULATION_V4;
                } else {
                    //scenario for internal shipments
                    $apiUrl = $this->_config->getApiUrl() . self::SHIPPING_CALCULATION;
                }
                $client->setUri($apiUrl);
                $client->setParameterPost($data);
                $request = $this->doRequest($client);
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->info('Shipping Calculation: ' . $this->_serializer->serialize($data));
                }
                if ($request['success']) {
                    return $this->_serializer->unserialize($request["body"]);
                }
            } catch (\Exception | CouldNotSaveException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->critical('Shipping Calculation: ' . $e->getMessage());
                }
            }
        }
        return [];
    }
}
