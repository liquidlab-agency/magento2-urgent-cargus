<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 05.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Observer\Backend;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

/**
 * Class Pudo
 *
 * Insert pudo id in awb_expeditii table if is the case.
 */
class Pudo implements ObserverInterface
{
    /** @var OrderRepositoryInterface $_orderRepository */
    protected OrderRepositoryInterface $_orderRepository;
    /** @var ResourceConnection $_resourceConnection */
    protected ResourceConnection $_resourceConnection;

    /**
     * Constructor
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ResourceConnection       $resourceConnection
    ) {
        $this->_orderRepository = $orderRepository;
        $this->_resourceConnection = $resourceConnection;
    }

    /**
     * Method execute
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $orderId = $observer->getOrderId();
        $awbData = $observer->getAwbData();
        if ($orderId > 0 && $awbData->getId() > 0) {
            try {
                /** @var Order $order */
                $order = $this->_orderRepository->get($orderId);
                $shippingAddress = $order->getShippingAddress();
                if ($shippingAddress && $shippingAddress->getPudoId() > 0) {
                    $this->updateAwbData((int)$awbData->getId(), (int)$shippingAddress->getPudoId());
                }
            } catch (NoSuchEntityException $noSuchEntityException) {
                $awbData->setError(true);
                $this->deleteAwbData((int)$awbData->getId());
            }
        }
    }

    /**
     * Method updateAwbData
     *
     * @param int $awbId
     * @param int $pudoId
     *
     * @return void
     * @throws NoSuchEntityException
     */
    private function updateAwbData(int $awbId, int $pudoId): void
    {
        $connection = $this->_resourceConnection->getConnection();
        $awbTable = $this->_resourceConnection->getTableName('awb_expeditii');

        /* Update current Awb with pudo_id if the order has this pudo_id set */
        $sqlQuery = sprintf('UPDATE `%s` SET `%s` = %d WHERE `%s` = %d;', $awbTable, 'pudo_id', $pudoId, 'id', $awbId);
        $connection->query($sqlQuery);

        /* Check if the pudo_id it was set */
        $sqlQuery = sprintf('SELECT * FROM `%s` WHERE `%s` = %d;', $awbTable, 'id', $awbId);
        $result = $connection->fetchRow($sqlQuery);

        if (!isset($result['pudo_id']) || (int)$result['pudo_id'] <= 0) {
            throw new NoSuchEntityException(__('Could not save this pudo point: %1', $pudoId));
        }
    }

    /**
     * Method deleteAwbData
     *
     * @param int $awbId
     *
     * @return void
     */
    private function deleteAwbData(int $awbId): void
    {
        $connection = $this->_resourceConnection->getConnection();
        $awbTable = $this->_resourceConnection->getTableName('awb_expeditii');

        $sqlQuery = sprintf('DELETE FROM `%s` WHERE `%s` = %d;', $awbTable, 'id', $awbId);
        $connection->query($sqlQuery);
    }
}
