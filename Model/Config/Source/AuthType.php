<?php

declare(strict_types=1);

namespace Commerce365\Core\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class AuthType implements OptionSourceInterface
{
    public const AUTH_TYPE_BASIC = 'base';
    public const AUTH_TYPE_OAUTH = 'oauth';

    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::AUTH_TYPE_BASIC,
                'label' => __('Basic')
            ],
            [
                'value' => self::AUTH_TYPE_OAUTH,
                'label' => __('OAuth')
            ],
        ];
    }
}
