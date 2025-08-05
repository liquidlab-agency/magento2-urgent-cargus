<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Urgent\Base\Api\Data\TokenInterface;

/**
 * Class Token Resource Model
 *
 * Description class.
 */
class Token extends AbstractDb
{
    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TokenInterface::TABLE_NAME, TokenInterface::ID);
    }
}
