<?php

namespace Commerce365\Core\Controller\Adminhtml\Connection;

use Commerce365\Core\Model\AdvancedConfig;
use Commerce365\Core\Service\Request\BusinessCentral\RefreshOAuthToken;
use Commerce365\Core\Service\Request\Post;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Message\ManagerInterface;

class OAuthCheck extends Action
{
    private Post $post;
    private AdvancedConfig $advancedConfig;
    private RefreshOAuthToken $refreshOAuthToken;

    public function __construct(
        Context $context,
        RefreshOAuthToken $refreshOAuthToken,
        AdvancedConfig $advancedConfig,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->messageManager = $messageManager;
        $this->advancedConfig = $advancedConfig;
        $this->refreshOAuthToken = $refreshOAuthToken;
    }

    public function execute()
    {
        $endpoint = $this->advancedConfig->getEndpoint();
        $tenantId = $this->advancedConfig->getTenantId();
        $clientId = $this->advancedConfig->getClientId();
        $clientSecret = $this->advancedConfig->getClientSecret();

        if (!$endpoint || !$tenantId || !$clientId || !$clientSecret) {
            $this->messageManager->addErrorMessage(__('First fill in all of the above fields!'));

            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
        }

        try {
            $this->refreshOAuthToken->execute();
            $this->messageManager->addSuccessMessage(__('Connected Successful'));

            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
        }
    }

    protected function _isAllowed(): bool
    {
        return true;
    }
}
