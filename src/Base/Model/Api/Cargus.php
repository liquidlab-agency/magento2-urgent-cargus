<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Api;

use Magento\Framework\DataObject;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Urgent\Base\Api\Data\TokenInterface;
use Urgent\Base\Api\Data\TokenInterfaceFactory;
use Urgent\Base\Api\TokenRepositoryInterface;
use Urgent\Base\Logger\Logger;
use Urgent\Base\Model\ResourceModel\Token\Collection as TokenCollection;
use Urgent\Base\Model\Config\Response;
use Urgent\Base\Model\Config\Config;
use Magento\Framework\HTTP\AsyncClient\Request;
use Magento\Framework\App\ProductMetadata;
use Magento\Analytics\Model\Connector\Http\Client\Curl;
use Magento\Framework\DataObjectFactory;

/**
 * Class Cargus
 *
 * With this class you can make requests api to cargus.
 */
abstract class Cargus
{
    private const LOGIN = 'LoginUser';

    /** @var Logger $_logger */
    protected Logger $_logger;
    /** @var Config $_config */
    protected Config $_config;
    /** @var TokenCollection $_tokenCollection */
    private TokenCollection $_tokenCollection;
    /** @var TimezoneInterface $_timezone */
    protected TimezoneInterface $_timezone;
    /** @var TokenInterfaceFactory $_tokenFactory */
    private TokenInterfaceFactory $_tokenFactory;
    /** @var TokenRepositoryInterface $_tokenRepository */
    private TokenRepositoryInterface $_tokenRepository;
    /** @var SerializerInterface $_serializer */
    protected SerializerInterface $_serializer;
    /** @var DirectoryList $_directoryList */
    protected DirectoryList $_directoryList;
    /** @var EncryptorInterface $_encryptor */
    protected EncryptorInterface $_encryptor;
    private ProductMetadata $productMetadata;
    private Curl $curl;
    private DataObjectFactory $dataObjectFactory;

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
     * @param ProductMetadata $productMetadata
     * @param Curl $curl
     * @param DataObjectFactory $dataObjectFactory
     */
    public function __construct(
        Logger                   $logger,
        Config                   $config,
        TokenCollection          $tokenCollection,
        TimezoneInterface        $timezone,
        TokenInterfaceFactory    $tokenFactory,
        TokenRepositoryInterface $tokenRepository,
        SerializerInterface      $serializer,
        DirectoryList            $directoryList,
        EncryptorInterface       $encryptor,
        ProductMetadata          $productMetadata,
        Curl                     $curl,
        DataObjectFactory        $dataObjectFactory
    )
    {
        $this->_logger = $logger;
        $this->_config = $config;
        $this->_tokenCollection = $tokenCollection;
        $this->_timezone = $timezone;
        $this->_tokenFactory = $tokenFactory;
        $this->_tokenRepository = $tokenRepository;
        $this->_serializer = $serializer;
        $this->_directoryList = $directoryList;
        $this->_encryptor = $encryptor;
        $this->productMetadata = $productMetadata;
        $this->curl = $curl;
        $this->dataObjectFactory = $dataObjectFactory;
    }

    /**
     * Method getClient
     *
     * @param string $method
     *
     * @return DataObject
     */
    protected function getClient(string $method = Request::METHOD_GET): DataObject
    {
        $headers = $this->getDefaultHeaders();
        $client = $this->dataObjectFactory->create();
        try {
            $client->setOptions([
                'timeout' => $this->_config->getApiTimeout(),
            ]);
            $client->setHeaders($headers);
            $client->setMethod($method);
        } catch (\Exception $e) {
            if ($this->_config->getDebugLogger()) {
                $this->_logger->critical($e->getMessage());
            }
        }
        return $client;
    }

    /**
     * @return string[]
     */
    private function getDefaultHeaders(): array
    {
        return [
            'Ocp-Apim-Subscription-Key: ' . $this->_config->getApiKey(),
            'Path: ' . $this->getVersionMagento(),
            'Content-Type: application/json'
        ];
    }

    /**
     * Method login
     *
     * @param bool $forceToken
     *
     * @return string
     * @throws CouldNotSaveException
     */
    protected function login(bool $forceToken = false): string
    {
        $currentDate = $this->_timezone->date();
        if (!$forceToken) {
            $token = $this->_tokenCollection
                ->setOrder('id')
                ->setPageSize(1);
            if ($token->getSize()) {
                $token = $token->getFirstItem();
                /** @var TokenInterface $token */
                $tokenDate = $this->_timezone->date($token->getAvailable());
                if (!$currentDate->diff($tokenDate)->invert) {
                    return $token->getToken();
                }
            }
        }

        /** @var DataObject $client */
        $client = $this->getClient(Request::METHOD_POST);
        try {
            $client->setUri($this->_config->getApiUrl() . self::LOGIN);
            $client->setParameterPost([
                'UserName' => $this->_config->getApiUsername(),
                'Password' => $this->_encryptor->decrypt($this->_config->getApiPassword()),
            ]);
            $request = $this->doRequest($client);
            if ($request['success']) {
                $token = $this->_tokenFactory->create();
                $token->setToken(trim($request["body"], '"'));

                $token->setAvailable($currentDate->modify('+20 hours')->format('Y-m-d H:i:s'));
                $this->_tokenRepository->save($token);
                return $token->getToken();
            }
        } catch (\Exception $e) {
            if ($this->_config->getDebugLogger()) {
                $this->_logger->critical($e->getMessage());
            }
        }
        return '';
    }

    /**
     * Method doRequest
     *
     * @param DataObject $client
     *
     * @return array
     */
    protected function doRequest(DataObject $client): array
    {
        $result = [
            'success' => true,
            'body' => ''
        ];

        if (!$this->_config->getApiIsActive()) {
            $result['success'] = false;
            $result['body'] = __('The urgent cargus api is disabled!');
            return $result;
        }

        try {
            $defaultHeaders = $this->getDefaultHeaders();
            $headers = $client->getHeaders();
            foreach ($headers as $key => $value) {
                $headerValue = $key . ': ' . $value;
                if (!in_array($headerValue, $defaultHeaders)) {
                    $defaultHeaders[] = $headerValue;
                }
            }

            $response = $this->curl->request(
                $client->getMethod(),
                $client->getUri(),
                $client->getParameterPost() ?? [],
                $defaultHeaders
            );

            if ($this->_config->getDebugLogger()) {
                $this->_logger->info($client->getUri(true));
            }
            $this->checkResponse($response, $result);
        } catch (\Exception $e) {
            if ($this->_config->getDebugLogger()) {
                $this->_logger->critical($e->getMessage());
            }
            $result['success'] = false;
            $result['body'] = __('Something went wrong: ') . '(' . $e->getMessage() . ')';
        }

        return $result;
    }

    /**
     * Method checkResponse
     *
     * @param $response
     * @param array $result
     *
     * @return void
     * @throws \Exception
     */
    private function checkResponse($response, array &$result): void
    {
        if ($response->getStatusCode() === Response::STATUS_CODE_200) {
            $result['body'] = $response->getBody();
            if ($this->_config->getDebugLogger()) {
                $this->_logger->info($result['body']);
            }
        } else {
            $throwMsg = 'Request Status: ' . $response->getStatusCode();
            $throwMsg .= ' Body: ' . $response->getBody();
            throw new \Exception($throwMsg);
        }
    }

    /**
     * Method getVersionMagento
     *
     * @return string
     */
    private function getVersionMagento(): string
    {
        // Version must have maxim 5 characters.
        return 'M' . substr(
                str_replace('.', '', $this->productMetadata->getVersion()),
                0, 4);
    }

    /**
     * Method execute
     *
     * @return mixed
     */
    abstract public function execute();
}
