<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\ResourceModel\Awb;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Urgent\Base\Model\Awb;

/**
 * Class Collection
 *
 * Description class.
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
        $this->_init(Awb::class, \Urgent\Base\Model\ResourceModel\Awb::class);
    }
}
