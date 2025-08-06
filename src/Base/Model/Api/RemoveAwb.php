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
use Urgent\Base\Api\Data\AwbInterface;

/**
 * Class RemoveAwb
 *
 * Description: Remove the awb from the cargus portal.
 */
class RemoveAwb extends Cargus
{
    protected const REMOVE_AWB = 'Awbs';

    /** @var AwbInterface $_awb */
    protected AwbInterface $_awb;

    /**
     * Method setAwb
     *
     * @param AwbInterface $awb
     * @return $this
     */
    public function setAwb(AwbInterface $awb): RemoveAwb
    {
        $this->_awb = $awb;
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
                $client = $this->getClient(Request::METHOD_DELETE);
                $client->setHeaders(['Authorization' => 'Bearer ' . $token]);
                $client->setUri($this->_config->getApiUrl() . self::REMOVE_AWB);
                $client->setParameterGet(['barCode' => $this->_awb->getAwbNo()]);
                $request = $this->doRequest($client);
                if ($request['success']) {
                    return (bool)$request["body"];
                }
            } catch (\Exception | CouldNotSaveException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->critical($e->getMessage());
                }
            }
        }
        return false;
    }
}
