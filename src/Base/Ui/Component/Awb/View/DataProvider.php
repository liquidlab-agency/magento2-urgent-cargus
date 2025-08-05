<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 19.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Ui\Component\Awb\View;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderInterfaceFactory;
use Magento\Sales\Model\OrderRepository;
use Magento\Sales\Model\Spi\OrderResourceInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Urgent\Base\Model\ResourceModel\Awb\CollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Address\CollectionFactory as AddressCollectionFactory;

/**
 * Class DataProvider
 *
 * Description class.
 */
class DataProvider extends ModifierPoolDataProvider
{
    /** @var array $loadedData */
    protected array $loadedData = [];
    /** @var OrderInterfaceFactory $_orderInterfaceFactory */
    private OrderInterfaceFactory $_orderInterfaceFactory;
    /** @var OrderResourceInterface $_orderResource */
    private OrderResourceInterface $_orderResource;
    /** @var AddressCollectionFactory $_addressCollection */
    private AddressCollectionFactory $_addressCollection;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param OrderInterfaceFactory $orderInterfaceFactory
     * @param OrderResourceInterface $orderResource
     * @param AddressCollectionFactory $addressCollection
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        OrderInterfaceFactory $orderInterfaceFactory,
        OrderResourceInterface $orderResource,
        AddressCollectionFactory $addressCollection,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        $this->_orderInterfaceFactory = $orderInterfaceFactory;
        $this->_orderResource = $orderResource;
        $this->_addressCollection = $addressCollection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Method getData
     *
     * @return array
     */
    public function getData(): array
    {

        if (count($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $awb) {
            /** @var OrderInterface $order */
            $order = $this->_orderInterfaceFactory->create();
            $this->_orderResource->load($order, $awb->getOrderId(), 'increment_id');

            if ($order->getEntityId()) {
                $shippingAddress = $this->_addressCollection->create()->addFieldToFilter(
                    'entity_id',
                    [$order->getShippingAddressId()],
                )->getFirstItem();
                if ($shippingAddress->getEntityId()) {
                    $awb->setCustomerCounty($shippingAddress->getRegion());
                    $awb->setCustomerLocality($shippingAddress->getCity());
                    $awb->setDestinationLocalityOriginal($awb->getDestinationLocality());
                    $awb->setCurrency($order->getOrderCurrencyCode());
                }
            }

            $this->loadedData[$awb->getData('id')] = $awb->getData();
        }

        return $this->loadedData;
    }
}
