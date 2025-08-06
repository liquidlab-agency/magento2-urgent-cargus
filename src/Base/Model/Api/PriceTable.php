<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 24.10.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class PriceTable
 *
 * Description class.
 */
class PriceTable extends Cargus
{
    protected const PRICE_TABLES = 'PriceTables';

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
                $client->setUri($this->_config->getApiUrl() . self::PRICE_TABLES);
                $request = $this->doRequest($client);
                if ($request['success']) {
                    return $this->_serializer->unserialize($request["body"]);
                }
            } catch (\Exception | CouldNotSaveException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->critical($e->getMessage());
                }
            }
        }
        return [];
    }
}
