<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 04.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusShipGo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Urgent\CargusShipGo\Api\Data\PudoInterface;

class Pudo extends AbstractDb
{
    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(PudoInterface::TABLE, PudoInterface::ID);
    }
}
