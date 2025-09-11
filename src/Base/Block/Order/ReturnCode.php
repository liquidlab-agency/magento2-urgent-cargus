<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 14.03.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Block\Order;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Urgent\Base\Api\AwbRepositoryInterface;
use Urgent\Base\Model\QrCodeFactory;

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
    /** @var QrCodeFactory $_qrCodeFactory */
    private QrCodeFactory $_qrCodeFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $registry
     * @param AwbRepositoryInterface $awbRepository
     * @param QrCodeFactory $qrCodeFactory
     * @param array $data
     */
    public function __construct(
        Template\Context       $context,
        Registry               $registry,
        AwbRepositoryInterface $awbRepository,
        QrCodeFactory          $qrCodeFactory,
        array                  $data = []
    ) {
        $this->_registry = $registry;
        $this->_awbRepository = $awbRepository;
        $this->_qrCodeFactory = $qrCodeFactory;
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
            // Use the factory to create a QrCode with the return code data
            // and appropriate configuration
            $qrCode = $this->_qrCodeFactory->create(
                $this->_returnCode,  // data parameter (required)
                200,                // size parameter
                $this->_returnCode   // label parameter
            );

            // Use the factory to write the QR code to SVG string
            return $this->_qrCodeFactory->writeString($qrCode);
        }
        return '';
    }
}
