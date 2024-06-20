<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Request\BusinessCentral;

use Commerce365\Core\Model\AdvancedConfig;
use Magento\Framework\Exception\LocalizedException;

class GetBCEndpointUrl
{
    public function __construct(private readonly AdvancedConfig $advancedConfig) {}

    public function execute(string $method): string
    {
        $endpoint = $this->advancedConfig->getEndpoint();
        $environment = $this->advancedConfig->getEnvironment();
        $company = $this->advancedConfig->getCompany();

        if ($this->advancedConfig->isBCOAuth()) {
            $tenantId = $this->advancedConfig->getTenantId();
            if (!$tenantId) {
                throw new LocalizedException(__('Tenant Id should be configured'));
            }
            $endpoint = rtrim($endpoint, '/') . '/' . $tenantId;
        }

        return rtrim($endpoint, '/') . '/' . $environment . '/ODataV4/' . $method . '?company=' . rawurlencode($company);
    }
}
