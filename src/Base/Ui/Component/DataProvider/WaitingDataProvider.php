<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 26.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Ui\Component\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Urgent\Base\Api\Data\AwbInterface;
use Urgent\Base\Model\ResourceModel\Awb\CollectionFactory;

/**
 * Class WaitingDataProvider
 *
 * Description: Load only awbs that are not valid with an awb number.
 */
class WaitingDataProvider extends AbstractDataProvider
{
    /** @var array $loadedData */
    protected array $loadedData = [];

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Method getData
     *
     * @return array
     */
    public function getData(): array
    {
        $collection = $this->getCollection()
            ->addFieldToFilter(AwbInterface::AWB_NO, ['null' => true]);

        $collection->getSelect()->joinLeft(
            ['order_table' => $collection->getTable('sales_order')],
            'main_table.order_id = order_table.increment_id',
            ['currency_code' => 'order_table.order_currency_code']
        );

        $this->loadedData = $collection->load()->toArray();
        return $this->loadedData;
    }
}
