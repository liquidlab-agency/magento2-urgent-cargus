<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 03.06.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Urgent\Base\Api\Data\AwbInterface;
use Urgent\Base\Ui\Component\Valid\Listing\Column\Actions;

/**
 * Class PrintAwb
 *
 * Description: Get AWB document from cargus portal.
 */
class PrintAwb extends Cargus
{
    private const DOCUMENT_AWB = 'AwbDocuments';
    private const TYPE_PDF = 'PDF';
    private const FORMAT_A4 = 0;

    /** @var AwbInterface $_awb */
    private AwbInterface $_awb;
    /** @var int $_printType */
    private int $_printType;

    /**
     * Method setAwb
     *
     * @param AwbInterface $awb
     * @return $this
     */
    public function setAwb(AwbInterface $awb): PrintAwb
    {
        $this->_awb = $awb;
        return $this;
    }

    /**
     * Method setPrintType
     *
     * @param int $type
     * @return $this
     */
    public function setPrintType(int $type = Actions::TYPE_PRINT_ONLY_AWB): PrintAwb
    {
        $this->_printType = $type;
        return $this;
    }

    /**
     * Method execute
     *
     * @return string|null
     */
    public function execute(): ?string
    {
        if ($this->_config->getApiIsActive()) {
            try {
                $data = [
                    'barCodes' => $this->_awb->getAwbNo(),
                    'type' => self::TYPE_PDF,
                    'format' => self::FORMAT_A4,
                ];

                if ($this->_config->getGeneralConsumerReturn() !== 0) {
                    $data['printReturn'] = $this->_printType;
                }

                $token = $this->login();
                $client = $this->getClient();
                $client->setHeaders(['Authorization' => 'Bearer ' . $token]);
                $getParams = http_build_query($data);
                $client->setUri($this->_config->getApiUrl() . self::DOCUMENT_AWB . '?' . $getParams);
                $request = $this->doRequest($client);
                if ($request['success']) {
                    return $request["body"];
                }
            } catch (\Exception | CouldNotSaveException $e) {
                if ($this->_config->getDebugLogger()) {
                    $this->_logger->critical($e->getMessage());
                }
            }
        }
        return null;
    }
}
