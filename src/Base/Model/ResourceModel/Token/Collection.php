<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 31.03.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Model\ResourceModel\Token;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Urgent\Base\Model\Token;

/**
 * Class Token Collection
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
        $this->_init(Token::class, \Urgent\Base\Model\ResourceModel\Token::class);
    }
}
