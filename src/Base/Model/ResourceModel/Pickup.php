<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 29.06.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Urgent\Base\Api\Data\PickupInterface;

/**
 * Class Pickup
 *
 * Description: ...
 */
class Pickup extends AbstractDb
{
    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(PickupInterface::TABLE_NAME, PickupInterface::ID);
    }
}
