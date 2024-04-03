<?php

namespace Commerce365\Core\Block\Adminhtml\System\Config\Buttons\BusinessCentral;

use Commerce365\Core\Block\Adminhtml\System\Config\Buttons\AbstractCheckConnection;

class OauthCheckConnection extends AbstractCheckConnection
{
    private const TEST_CONNECTION_URL = 'commerce365_configuration/connection/OAuthCheck';

    public function getRedirectUrl(): string
    {
        return $this->getUrl(self::TEST_CONNECTION_URL);
    }
}
