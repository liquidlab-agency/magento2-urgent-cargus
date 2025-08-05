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
use Laminas\Http\Exception\RuntimeException as LaminasHttpException;

/**
 * Class City
 *
 * Description: ...
 */
class City extends Cargus
{
    /** @const string CITIES */
    private const CITIES = 'Localities';

    /** @var int $_countryId */
    private int $_countryId = 0;
    /** @var int $_countyId */
    private int $_countyId = 0;

    /**
     * Method execute
     *
     * @return array
     */
    public function execute(): array
    {
        if ($this->_config->getApiIsActive() && $this->_countryId > 0 && $this->_countyId > 0) {
            $client = $this->getClient();
            try {
                $token = $this->login();
                $client->setHeaders(['Authorization' => 'Bearer ' . $token]);
                $client->setUri($this->_config->getApiUrl() . self::CITIES);
                $client->setParameterGet([
                    'countryId' => $this->_countryId,
                    'countyId' => $this->_countyId
                ]);
                $request = $this->doRequest($client);
                if ($request['success']) {
                    return $this->_serializer->unserialize($request["body"]);
                }
            } catch (LaminasHttpException|CouldNotSaveException $e) {
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
    public function setCountryId(int $countryId): City
    {
        $this->_countryId = $countryId;
        return $this;
    }

    /**
     * Method setCountyId
     *
     * @param int $countyId
     * @return $this
     */
    public function setCountyId(int $countyId): City
    {
        $this->_countyId = $countyId;
        return $this;
    }
}
