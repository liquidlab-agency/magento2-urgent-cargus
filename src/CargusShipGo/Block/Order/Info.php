<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 06.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Block\Order;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\Order;
use Urgent\CargusShipGo\Api\Data\PudoInterface;
use Urgent\CargusShipGo\Api\PudoRepositoryInterface;
use Urgent\CargusShipGo\Model\Carrier\ShipAndGo;

/**
 * Class Info
 *
 * Description class.
 */
class Info extends Template
{
    /** @var PudoInterface|null $_pudo */
    protected ?PudoInterface $_pudo = null;

    /** @var Registry $coreRegistry */
    protected Registry $_coreRegistry;
    /** @var PudoRepositoryInterface $_pudoRepository */
    protected PudoRepositoryInterface $_pudoRepository;

    /**
     * @param Template\Context $context
     * @param Registry $registry
     * @param PudoRepositoryInterface $pudoRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        PudoRepositoryInterface $pudoRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
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
        return $this->_coreRegistry->registry('current_order');
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
