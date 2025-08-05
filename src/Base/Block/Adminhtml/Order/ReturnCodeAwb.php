<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 14.03.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Block\Adminhtml\Order;

use Magento\Backend\Block\Template;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\Registry;
use Urgent\Base\Api\AwbRepositoryInterface;
use Urgent\Base\Api\Data\AwbInterface;

/**
 * Class ReturnCodeAwb
 *
 * Description class.
 */
class ReturnCodeAwb extends Template
{
    private ?string $_returnCode = null;
    private ?string $_returnAwb = null;
    private ?AwbInterface $_awbData;

    /** @var Registry $_registry */
    private Registry $_registry;
    /** @var AwbRepositoryInterface $_awbRepository */
    private AwbRepositoryInterface $_awbRepository;

    public function __construct(
        Template\Context       $context,
        Registry               $registry,
        AwbRepositoryInterface $awbRepository,
        array                  $data = [],
        ?JsonHelper            $jsonHelper = null,
        ?DirectoryHelper       $directoryHelper = null
    ) {
        $this->_registry = $registry;
        $this->_awbRepository = $awbRepository;
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
        $this->getOrder();
    }


    /**
     * Method getOrder
     *
     * @return mixed|null
     */
    public function getOrder()
    {
        $order = $this->_registry->registry('current_order');
        if ($order) {
            $this->_awbData = $this->_awbRepository->getByIncrementId($order->getIncrementId());
        }
        return $order;
    }

    /**
     * Method getReturnCode
     *
     * @return string|null
     */
    public function getReturnCode(): ?string
    {
        if ($this->_awbData !== null && $this->_awbData->getId() && $this->_awbData->getReturnCode()) {
            $this->_returnCode = $this->_awbData->getReturnCode();
        }
        return $this->_returnCode;
    }

    /**
     * Method getReturnAwb
     *
     * @return string|null
     */
    public function getReturnAwb(): ?string
    {
        if ($this->_awbData !== null && $this->_awbData->getId() && $this->_awbData->getReturnAwb()) {
            $this->_returnAwb = $this->_awbData->getReturnAwb();
        }
        return $this->_returnAwb;
    }
}
