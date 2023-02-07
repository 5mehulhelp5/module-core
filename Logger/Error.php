<?php

namespace Commerce365\Core\Logger;

use Monolog\Logger;

class Error extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::WARNING;
}
