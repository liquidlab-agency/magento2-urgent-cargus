<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Urgent\Base\Api\Data\AwbInterface;

/**
 * Class Awb
 *
 * Description class.
 */
class Awb extends AbstractDb
{
    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(AwbInterface::TABLE_NAME, AwbInterface::ID);
    }
}
