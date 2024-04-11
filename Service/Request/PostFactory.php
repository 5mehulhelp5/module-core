<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Request;

use Commerce365\Core\Model\AdvancedConfig;
use Commerce365\Core\Service\Request\BusinessCentral\BasicPost;
use Commerce365\Core\Service\Request\BusinessCentral\OAuthPost;
use Magento\Framework\ObjectManagerInterface;

class PostFactory
{
    private ObjectManagerInterface $objectManager;
    private AdvancedConfig $advancedConfig;

    public function __construct(ObjectManagerInterface $objectManager, AdvancedConfig $advancedConfig)
    {
        $this->objectManager = $objectManager;
        $this->advancedConfig = $advancedConfig;
    }

    public function create(): PostInterface
    {
        if ($this->advancedConfig->isBCOAuth()) {
            return $this->objectManager->create(OAuthPost::class);
        }

        if ($this->advancedConfig->isBCBasic()) {
            return $this->objectManager->create(BasicPost::class);
        }

        return $this->objectManager->create(Post::class);
    }
}
