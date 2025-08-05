<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 02.06.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Urgent\Base\Api\Data\PickupInterface;
use Laminas\Http\Request;
use Laminas\Http\Exception\RuntimeException as LaminasHttpException;

/**
 * Class SendOrder
 *
 * Description: Send the order for truck when to come and where.
 */
class SendOrder extends Cargus
{
    protected const SEND_ORDER = 'Orders';

    /** @var PickupInterface $_pickupData */
    protected PickupInterface $_pickupData;

    /**
     * Method addAwbData
     *
     * @param PickupInterface $pickup
     * @return $this
     */
    public function addPickupData(PickupInterface $pickup): self
    {
        $this->_pickupData = $pickup;
        return $this;
    }

    /**
     * Method execute
     *
     * @return bool
     */
    public function execute(): bool
    {
        if ($this->_config->getApiIsActive()) {
            try {
                $token = $this->login();
                $client = $this->getClient(Request::METHOD_PUT);
                $client->setHeaders(['Authorization' => 'Bearer ' . $token]);
                $client->setUri($this->_config->getApiUrl() . self::SEND_ORDER);
                $client->setParameterGet([
                    'locationId' => $this->_pickupData->getLocationId(),
                    'PickupStartDate' => $this->_pickupData->getStartDate(),
                    'PickupEndDate' => $this->_pickupData->getEndDate(),
                    'action' => $this->_pickupData->getStatus()
                ]);

                $request = $this->doRequest($client);
                if ($request['success']) {
                    return (bool)$request["body"];
                }
            } catch (LaminasHttpException | CouldNotSaveException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->critical($e->getMessage());
                }
            }
        }
        return false;
    }
}
