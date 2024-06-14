<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Request\BusinessCentral;

use Commerce365\Core\Model\AdvancedConfig;

class GetBCEndpointUrl
{
    private AdvancedConfig $advancedConfig;

    public function __construct(AdvancedConfig $advancedConfig)
    {
        $this->advancedConfig = $advancedConfig;
    }

    public function execute(string $method): string
    {
        if ($this->advancedConfig->isBCOAuth()) {
            return $this->getOAuthUrl($method);
        }

        $endpoint = $this->advancedConfig->getEndpoint();
        $company = $this->advancedConfig->getCompany();

        return rtrim($endpoint, '/') . '/ODataV4/' . $method . '?company=' . rawurlencode($company);
    }

    private function getOAuthUrl($method): string
    {
        $tenantId = $this->advancedConfig->getTenantId();
        if (!$tenantId) {
            return '';
        }

        $endpoint = $this->advancedConfig->getEndpoint();
        $environment = $this->advancedConfig->getEnvironment();
        $company = $this->advancedConfig->getCompany();

        return rtrim($endpoint, '/') . '/' . $tenantId . '/' . $environment . '/ODataV4/' . $method . '?company=' . rawurlencode($company);
    }
}
