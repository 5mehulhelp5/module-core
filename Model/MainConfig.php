<?php

declare(strict_types=1);

namespace Commerce365\Core\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class MainConfig
{
    private const XML_PATH_NONWEB_ORDERS = 'b2b/b2b_offlineorders';
    private const XML_PATH_HUB_URL = 'hub/hub_url';
    private const XML_PATH_HUB_APPID = 'hub/hub_appid';
    private const XML_PATH_HUB_SECRETKEY = 'hub/hub_secretkey';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getIncludeNonWebOrders()
    {
        return $this->getConfigValue(self::XML_PATH_NONWEB_ORDERS, 'store');
    }

    public function getHubUrl()
    {
        return $this->getConfigValue(self::XML_PATH_HUB_URL, 'website');
    }

    public function getHubAppId()
    {
        return $this->getConfigValue(self::XML_PATH_HUB_APPID, 'website');
    }

    public function getHubSecretKey()
    {
        return $this->getConfigValue(self::XML_PATH_HUB_SECRETKEY, 'website');
    }

    public function getConfigValue($path, $scope)
    {
        return $this->scopeConfig->getValue('commerce365config_general/' . $path, $scope);
    }
}
