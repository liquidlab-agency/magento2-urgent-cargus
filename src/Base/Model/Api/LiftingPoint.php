<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 17.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class LiftingPoint
 *
 * Description class.
 */
class LiftingPoint extends Cargus
{
    protected const PICKUP_LOCATIONS = 'PickupLocations';

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
                $client->setUri($this->_config->getApiUrl() . self::PICKUP_LOCATIONS);
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
