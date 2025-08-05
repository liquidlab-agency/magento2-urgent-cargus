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
use Urgent\Base\Api\Data\CountryInterface;

/**
 * Class Country
 *
 * Description: ...
 */
class Country extends AbstractDb
{
    protected $_isPkAutoIncrement = false;
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(CountryInterface::TABLE_NAME, CountryInterface::COUNTRY_ID);
    }
}
