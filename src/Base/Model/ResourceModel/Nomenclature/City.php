<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 09.01.2023
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\ResourceModel\Nomenclature;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Urgent\Base\Api\Data\CityInterface;

/**
 * Class City
 *
 * Description: ...
 */
class City extends AbstractDb
{
    protected $_isPkAutoIncrement = false;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CityInterface::TABLE_NAME, CityInterface::COUNTY_ID);
    }
}
