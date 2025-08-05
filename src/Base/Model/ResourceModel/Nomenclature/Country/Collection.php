<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 09.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\ResourceModel\Nomenclature\Country;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Urgent\Base\Api\Data\CountryInterface;
use Urgent\Base\Model\Nomenclature\Country;

/**
 * Class Collection
 *
 * Description: ...
 */
class Collection extends AbstractCollection
{
    /** @var string $_idFieldName */
    protected $_idFieldName = CountryInterface::COUNTRY_ID;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Country::class, \Urgent\Base\Model\ResourceModel\Nomenclature\Country::class);
    }
}
