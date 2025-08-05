<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 29.06.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\ResourceModel\Pickup;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Urgent\Base\Model\Pickup;

/**
 * Class Collection
 *
 * Description: ...
 */
class Collection extends AbstractCollection
{
    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Pickup::class, \Urgent\Base\Model\ResourceModel\Pickup::class);
    }
}
