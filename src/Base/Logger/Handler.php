<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 19.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\Base\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * Class Handler
 *
 * Description class.
 */
class Handler extends Base
{
    protected $fileName = '/var/log/urgent_cargus.log';
}
