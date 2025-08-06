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
 * Class Country
 *
 * Description: ...
 */
class Country extends Cargus
{
    /** @const string COUNTRIES */
    private const COUNTRIES = 'Countries';

    /**
     * Method execute
     *
     * @return array
     */
    public function execute(): array
    {
        if ($this->_config->getApiIsActive()) {
            $client = $this->getClient();
            try {
                $token = $this->login();
                $client->setHeaders(['Authorization' => 'Bearer ' . $token]);
                $client->setUri($this->_config->getApiUrl() . self::COUNTRIES);
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
}