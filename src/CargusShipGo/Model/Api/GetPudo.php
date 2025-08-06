<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 01.04.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Model\Api;

use Urgent\Base\Model\Api\Cargus;

/**
 * Class GetPudo
 *
 * Add method to get list of pudo points.
 */
class GetPudo extends Cargus
{
    private const PUDO =  'PudoPoints';

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
                $client->setHeaders('Content-Type', null);
                $client->setUri($this->_config->getApiUrl() . self::PUDO);
                $request = $this->doRequest($client);
                if ($request['success']) {
                    return $this->_serializer->unserialize($request["body"]);
                }
            } catch (\Exception $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->critical($e->getMessage());
                }
            }
        }
        return [];
    }
}
