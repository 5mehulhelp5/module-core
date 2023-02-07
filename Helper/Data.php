<?php

namespace Commerce365\Core\Helper;

use GuzzleHttp\Client;
use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    protected $_hubUrl;
    protected $_logger;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Commerce365\Core\Logger\Logger $logger
    ) {
        $this->_hubUrl = $scopeConfig->getValue('commerce365config_general/hub/hub_url', 'website');
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

    public function getCustomerId()
    {
        if ($customerId = $this->customerSession->getCustomerId()) {
            return $customerId;
        }

        if ($customerId = $this->httpContext->getValue(ContextPlugin::CUSTOMER_ID)) {
            return $customerId;
        }
    }
}
