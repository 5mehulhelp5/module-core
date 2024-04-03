<?php

namespace Commerce365\Core\Controller\Adminhtml\Connection;

use Commerce365\Core\Model\MainConfig;
use Commerce365\Core\Service\Request\Post;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Message\ManagerInterface;

class Check extends Action
{
    private Post $post;
    private MainConfig $mainConfig;

    public function __construct(
        Post $post,
        Context $context,
        MainConfig $mainConfig,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->post = $post;
        $this->mainConfig = $mainConfig;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        $apiUrl = $this->mainConfig->getHubUrl();
        $appId = $this->mainConfig->getHubAppId();
        $secretKey = $this->mainConfig->getHubSecretKey();

        if ($apiUrl === '' || $appId === '' || $secretKey === '') {
            $this->messageManager->addErrorMessage(__('First fill in all of the above fields!'));
            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
        }

        try {
            $body = $this->post->execute(
                'ConnectionStatus',
                ['json' => [
                    'AppId' => $appId,
                    'SecretKey' => $secretKey
                ]],
                $apiUrl
            );

            $apiConnectionStatusCode = $body["bcApiStatusCode"] ?? 500;
            $statusMessage = $body["bcApiConnectionMessage"] ?? __('Unknown Error');

            if ($apiConnectionStatusCode === 200) {
                $this->messageManager->addSuccessMessage(__('Connected Successful'));
                return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
            }

            $this->messageManager->addErrorMessage($statusMessage);
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
