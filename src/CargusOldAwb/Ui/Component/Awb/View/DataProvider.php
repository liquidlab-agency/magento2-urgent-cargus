<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 19.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusOldAwb\Ui\Component\Awb\View;

use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Urgent\CargusOldAwb\Model\ResourceModel\OldAwb\CollectionFactory;

/**
 * Class DataProvider
 *
 * Description class.
 */
class DataProvider extends ModifierPoolDataProvider
{
    /** @var array $loadedData */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Method getData
     *
     * @return array
     */
    public function getData(): array
    {

        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $oldAwb) {
            $this->loadedData[$oldAwb->getData('id')] = $oldAwb->getData();
        }

        return $this->loadedData;
    }
}
