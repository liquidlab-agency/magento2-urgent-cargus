<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 06.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Block\Adminhtml\Order;

use Magento\Backend\Block\Template;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;
use Urgent\CargusShipGo\Api\Data\PudoInterface;
use Urgent\CargusShipGo\Api\PudoRepositoryInterface;
use Urgent\CargusShipGo\Model\Carrier\ShipAndGo;

/**
 * Class Pudo
 *
 * Description class.
 */
class Pudo extends Template
{
    /** @var PudoInterface|null $_pudo */
    protected ?PudoInterface $_pudo = null;
    /** @var Registry $_coreRegistry */
    protected Registry $_coreRegistry;
    /** @var PudoRepositoryInterface $_pudoRepository */
    protected PudoRepositoryInterface $_pudoRepository;

    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param Registry $registry
     * @param PudoRepositoryInterface $pudoRepository
     * @param array $data
     * @param JsonHelper|null $jsonHelper
     * @param DirectoryHelper|null $directoryHelper
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        PudoRepositoryInterface $pudoRepository,
        array $data = [],
        ?JsonHelper $jsonHelper = null,
        ?DirectoryHelper $directoryHelper = null
    ) {
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
        $this->_coreRegistry = $registry;
        $this->_pudoRepository = $pudoRepository;
    }

    /**
     * Method getOrder
     *
     * @return mixed|null
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('sales_order');
    }

    /**
     * Method hasPudo
     *
     * @return bool
     */
    public function hasPudo(): bool
    {
        /** @var Order $order */
        $order = $this->getOrder();
        $result = false;
        if ($order->getShippingMethod() === ShipAndGo::CODE . '_' . ShipAndGo::CODE) {
            $shippingAddress = $order->getShippingAddress();
            if ($shippingAddress && $shippingAddress->getPudoId() > 0) {
                try {
                    $this->_pudo = $this->_pudoRepository->getByPudoId((int)$shippingAddress->getPudoId());
                    $result = true;
                } catch (NoSuchEntityException $e) {
                    $result = false;
                }
            }
        }
        return $result;
    }

    /**
     * Method getPudo
     *
     * @return PudoInterface|null
     */
    public function getPudo(): ?PudoInterface
    {
        return $this->_pudo;
    }
}
