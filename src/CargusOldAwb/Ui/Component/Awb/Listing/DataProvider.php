<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 26.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusOldAwb\Ui\Component\Awb\Listing;

use Magento\Framework\App\ResourceConnection;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Urgent\CargusOldAwb\Api\Data\OldAwbInterface;
use Urgent\CargusOldAwb\Model\ResourceModel\OldAwb\CollectionFactory;

/**
 * Class DataProvider
 *
 * Description: Load old awb from this table awb_expeditii if it exists.
 */
class DataProvider extends AbstractDataProvider
{
    /** @var array $loadedData */
    protected array $loadedData = [];
    protected ResourceConnection $resourceConnection;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param ResourceConnection $resourceConnection
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        ResourceConnection $resourceConnection,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Method getData
     *
     * @return array
     */
    public function getData(): array
    {
        $resourceConn = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName(OldAwbInterface::TABLE_NAME);
        if (!$resourceConn->isTableExists($table)) {
            return [
                'totalRecords' => 0,
                'items' => []
            ];
        }

        if (count($this->loadedData) === 0) {
            $this->loadedData = $this->getCollection()->load()->toArray();
        }

        return $this->loadedData;
    }
}
