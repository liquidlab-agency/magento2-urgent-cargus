<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusOldAwb\Model\ResourceModel\OldAwb;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Urgent\CargusOldAwb\Model\OldAwb;

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
        $this->_init(OldAwb::class, \Urgent\CargusOldAwb\Model\ResourceModel\OldAwb::class);
    }
}
