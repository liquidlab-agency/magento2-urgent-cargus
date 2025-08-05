<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 09.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\ResourceModel\Nomenclature\City;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Urgent\Base\Api\Data\CityInterface;
use Urgent\Base\Model\Nomenclature\City;

/**
 * Class Collection
 *
 * Description: ...
 */
class Collection extends AbstractCollection
{
    /** @var string $_idFieldName */
    protected $_idFieldName = CityInterface::LOCALITY_ID;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(City::class, \Urgent\Base\Model\ResourceModel\Nomenclature\City::class);
    }
}
