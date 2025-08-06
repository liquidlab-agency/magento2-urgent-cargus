<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 09.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Api\Nomenclature;

use Magento\Framework\Exception\CouldNotSaveException;
use Urgent\Base\Model\Api\Cargus;

/**
 * Class County
 *
 * Description: ...
 */
class County extends Cargus
{
    /** @const string COUNTIES */
    private const COUNTIES = 'Counties?countryId=1';

    /** @var int $_countryId */
    private int $_countryId = 0;

    /**
     * Method execute
     *
     * @return array
     */
    public function execute(): array
    {
        if ($this->_config->getApiIsActive() && $this->_countryId > 0) {
            $client = $this->getClient();
            try {
                $token = $this->login();
                $client->setHeaders(['Authorization' => 'Bearer ' . $token]);
                $client->setUri($this->_config->getApiUrl() . self::COUNTIES);//TODO fix this to be dynamic??
                $client->setParameterGet(['countryId' => $this->_countryId]);
                $request = $this->doRequest($client);
                if ($request['success']) {
                    return $this->_serializer->unserialize($request["body"]);
                }
            } catch (\Exception|CouldNotSaveException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->critical($e->getMessage());
                }
            }
        }
        return [];
    }

    /**
     * Method setCountryId
     *
     * @param int $countryId
     * @return $this
     */
    public function setCountryId(int $countryId): County
    {
        $this->_countryId = $countryId;
        return $this;
    }
}