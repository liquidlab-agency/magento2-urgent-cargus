<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 14.03.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Block\Order;

use Endroid\QrCode\QrCode;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Urgent\Base\Api\AwbRepositoryInterface;

/**
 * Class ReturnCode
 *
 * Description: ...
 */
class ReturnCode extends Template
{
    private ?string $_returnCode = null;

    /** @var Registry $_registry */
    private Registry $_registry;
    /** @var AwbRepositoryInterface $_awbRepository */
    private AwbRepositoryInterface $_awbRepository;
    /** @var QrCode $_qrCode */
    private QrCode $_qrCode;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $registry
     * @param AwbRepositoryInterface $awbRepository
     * @param QrCode $qrCode
     * @param array $data
     */
    public function __construct(
        Template\Context       $context,
        Registry               $registry,
        AwbRepositoryInterface $awbRepository,
        QrCode                 $qrCode,
        array                  $data = []
    ) {
        $this->_registry = $registry;
        $this->_awbRepository = $awbRepository;
        $this->_qrCode = $qrCode;
        parent::__construct($context, $data);
    }

    /**
     * Method getOrder
     *
     * @return mixed|null
     */
    public function getOrder()
    {
        return $this->_registry->registry('current_order');
    }

    /**
     * Method getReturnCode
     *
     * @return string|null
     */
    public function getReturnCode(): ?string
    {
        $order = $this->getOrder();
        if ($order) {
            $awbData = $this->_awbRepository->getByIncrementId($order->getIncrementId());
            $this->_returnCode = $awbData !== null && $awbData->getId() && $awbData->getReturnCode() ?
                $awbData->getReturnCode() : null;
        }
        return $this->_returnCode;
    }

    /**
     * Method getQrReturnCode
     *
     * @return string
     */
    public function getQrReturnCode(): string
    {
        if ($this->_returnCode) {
            $qrCode = $this->_qrCode;
            $qrCode->setWriterByName('svg');
            $qrCode->setText($this->_returnCode);
            $qrCode->setLabel($this->_returnCode);
            $qrCode->setSize(200);

            return $qrCode->writeString();
        }
        return '';
    }
}
