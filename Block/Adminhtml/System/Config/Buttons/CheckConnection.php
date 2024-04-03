<?php

namespace Commerce365\Core\Block\Adminhtml\System\Config\Buttons;

class CheckConnection extends AbstractCheckConnection
{
    private const TEST_CONNECTION_URL = 'commerce365_configuration/connection/check';

    public function getRedirectUrl(): string
    {
        return $this->getUrl(self::TEST_CONNECTION_URL);
    }
}
