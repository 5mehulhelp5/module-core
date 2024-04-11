<?php

declare(strict_types=1);

namespace Commerce365\Core\Model;

use Commerce365\Core\Model\Config\Source\AuthType;
use Magento\Framework\App\Config\ScopeConfigInterface;

class AdvancedConfig
{
    private const XML_PATH_TENANT_ID = 'bc_config/tenant_id';
    private const XML_PATH_CLIENT_ID = 'bc_config/client_id';
    private const XML_PATH_AUTH_TYPE = 'bc_config/auth_type';
    private const XML_PATH_ENABLED = 'bc_config/enabled';
    private const XML_PATH_CLIENT_SECRET = 'bc_config/client_secret';
    private const XML_PATH_COMPANY_NAME = 'bc_config/company';
    private const XML_PATH_ENDPOINT = 'bc_config/endpoint';
    private const XML_PATH_USERNAME = 'bc_config/username';
    private const XML_PATH_PASSWORD = 'bc_config/password';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isBCOAuth()
    {
        return $this->getConfigValue(self::XML_PATH_AUTH_TYPE, 'website') === AuthType::AUTH_TYPE_OAUTH
            && $this->isSetConfigFlag(self::XML_PATH_ENABLED, 'website');
    }

    public function isBCBasic()
    {
        return $this->getConfigValue(self::XML_PATH_AUTH_TYPE, 'website') === AuthType::AUTH_TYPE_BASIC
            && $this->isSetConfigFlag(self::XML_PATH_ENABLED, 'website');
    }

    public function getTenantId()
    {
        return $this->getConfigValue(self::XML_PATH_TENANT_ID, 'website');
    }

    public function getClientId()
    {
        return $this->getConfigValue(self::XML_PATH_CLIENT_ID, 'website');
    }

    public function getClientSecret()
    {
        return $this->getConfigValue(self::XML_PATH_CLIENT_SECRET, 'website');
    }

    public function getEndpoint()
    {
        return $this->getConfigValue(self::XML_PATH_ENDPOINT, 'website');
    }

    public function getCompany()
    {
        return $this->getConfigValue(self::XML_PATH_COMPANY_NAME, 'website');
    }


    public function getConfigValue($path, $scope)
    {
        return $this->scopeConfig->getValue('commerce365config_advanced/' . $path, $scope);
    }

    public function isSetConfigFlag($path, $scope)
    {
        return $this->scopeConfig->isSetFlag('commerce365config_advanced/' . $path, $scope);
    }

    public function getUsername()
    {
        return $this->getConfigValue(self::XML_PATH_USERNAME, 'website');
    }

    public function getPassword()
    {
        return $this->getConfigValue(self::XML_PATH_PASSWORD, 'website');
    }
}
