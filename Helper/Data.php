<?php

namespace Commerce365\Core\Helper;

use Commerce365\Core\Logger\Logger;
use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    protected $_logger;

    public function __construct(Logger $logger)
    {
        $this->_logger = $logger;
    }

    public function LogEmergency(string $message)
    {
        $this->_logger->emergency($message);
    }

    public function LogCritical(string $message)
    {
        $this->_logger->critical($message);
    }

    public function LogError(string $message)
    {
        $this->_logger->error($message);
    }

    public function LogWarning(string $message)
    {
        $this->_logger->warning($message);
    }

    public function LogInfo(string $message)
    {
        $this->_logger->info($message);
    }

    public function LogDebug(string $message)
    {
        $this->_logger->debug($message);
    }
}
