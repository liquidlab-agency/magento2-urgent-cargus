<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 04.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Model\ResourceModel\Pudo;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Urgent\CargusShipGo\Model\Pudo;

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
        $this->_init(
            Pudo::class,
            \Urgent\CargusShipGo\Model\ResourceModel\Pudo::class
        );
    }
}
