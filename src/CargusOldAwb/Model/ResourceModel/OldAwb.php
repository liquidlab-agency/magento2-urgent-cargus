<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 19.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusOldAwb\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Urgent\CargusOldAwb\Api\Data\OldAwbInterface;

/**
 * Class OldAwb
 *
 * Description class.
 */
class OldAwb extends AbstractDb
{

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(OldAwbInterface::TABLE_NAME, OldAwbInterface::ID);
    }
}
