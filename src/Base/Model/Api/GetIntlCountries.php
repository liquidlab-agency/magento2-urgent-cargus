<?php

declare(strict_types=1);

namespace Urgent\Base\Model\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Laminas\Http\Exception\RuntimeException as LaminasHttpException;

class GetIntlCountries extends Cargus
{
    protected const COUNTRIES = 'intl-countries';

    /**
     * Method execute
     *
     * @return mixed
     */
    public function execute(): array
    {
        if ($this->_config->getApiIsActive()) {
            $client = $this->getClient();
            try {
                $token = $this->login();
                $client->setHeaders(['Authorization' => 'Bearer ' . $token]);
                $client->setUri($this->_config->getApiUrlV4() . self::COUNTRIES);
                $request = $this->doRequest($client);
                if ($request['success']) {
                    return $this->_serializer->unserialize($request["body"]);
                }
            } catch (LaminasHttpException | CouldNotSaveException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->critical($e->getMessage());
                }
            }
        }
        return [];
    }
}
