<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusOldAwb\Model;

use Magento\Framework\Model\AbstractModel;
use Urgent\CargusOldAwb\Api\Data\OldAwbInterface;

/**
 * Class OldAwb
 *
 * Description class.
 */
class OldAwb extends AbstractModel implements OldAwbInterface
{
    protected $_cacheTag = OldAwbInterface::TABLE_NAME;

    /**
     * Method _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\OldAwb::class);
    }
}
