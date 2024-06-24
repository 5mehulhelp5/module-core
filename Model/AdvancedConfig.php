<?php

declare(strict_types=1);

namespace Commerce365\Core\Model;

use Commerce365\Core\Model\Config\Source\AuthType;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class AdvancedConfig
{
    private const XML_PATH_TENANT_ID = 'bc_config/tenant_id';
    private const XML_PATH_ENVIRONMENT = 'bc_config/environment';
    private const XML_PATH_CLIENT_ID = 'bc_config/client_id';
    private const XML_PATH_AUTH_TYPE = 'bc_config/auth_type';
    private const XML_PATH_ENABLED = 'bc_config/enabled';
    private const XML_PATH_CLIENT_SECRET = 'bc_config/client_secret';
    private const XML_PATH_COMPANY_NAME = 'bc_config/company';
    private const XML_PATH_ENDPOINT = 'bc_config/endpoint';
    private const XML_PATH_USERNAME = 'bc_config/username';
    private const XML_PATH_PASSWORD = 'bc_config/password';

    public function __construct(private readonly ScopeConfigInterface $scopeConfig) {}

    public function isBCOAuth($storeId = null): bool
    {
        $isEnabled = $this->isSetConfigFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE, $storeId);
        $type = $this->getConfigValue(self::XML_PATH_AUTH_TYPE);

        return $type === AuthType::AUTH_TYPE_OAUTH && $isEnabled;
    }

    public function isBCBasic($storeId = null): bool
    {
        $isEnabled = $this->isSetConfigFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE, $storeId);
        $type = $this->getConfigValue(self::XML_PATH_AUTH_TYPE);

        return $type === AuthType::AUTH_TYPE_BASIC && $isEnabled;
    }

    public function getTenantId()
    {
        return $this->getConfigValue(self::XML_PATH_TENANT_ID);
    }

    public function getEnvironment()
    {
        return $this->getConfigValue(self::XML_PATH_ENVIRONMENT);
    }

    public function getClientId()
    {
        return $this->getConfigValue(self::XML_PATH_CLIENT_ID);
    }

    public function getClientSecret()
    {
        return $this->getConfigValue(self::XML_PATH_CLIENT_SECRET);
    }

    public function getEndpoint()
    {
        return $this->getConfigValue(self::XML_PATH_ENDPOINT);
    }

    public function getCompany()
    {
        return $this->getConfigValue(self::XML_PATH_COMPANY_NAME);
    }


    public function getConfigValue($path, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $storeId = null)
    {
        return $this->scopeConfig->getValue('commerce365config_advanced/' . $path, $scope, $storeId);
    }

    public function isSetConfigFlag($path, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag('commerce365config_advanced/' . $path, $scope, $storeId);
    }

    public function getUsername()
    {
        return $this->getConfigValue(self::XML_PATH_USERNAME);
    }

    public function getPassword()
    {
        return $this->getConfigValue(self::XML_PATH_PASSWORD);
    }
}
