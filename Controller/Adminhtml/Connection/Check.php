<?php

namespace Commerce365\Core\Controller\Adminhtml\Connection;

use Commerce365\Core\Service\Request\Post;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Check extends Action
{
    private Post $post;

    public function __construct(
        Post $post,
        Context $context
    ) {
        parent::__construct($context);
        $this->post = $post;
    }

    public function execute()
    {
        $apiUrl = $this->getRequest()->getParam('apiUrl');
        $appId = $this->getRequest()->getParam('appId');
        $secretKey = $this->getRequest()->getParam('secretKey');

        $apiUrl = trim($apiUrl);
        $appId = trim($appId);
        $secretKey = trim($secretKey);

        if ($apiUrl === '' || $appId === '' || $secretKey === '') {
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $resultJson->setData(
                [
                    'success' => false,
                    'error_message' => 'First fill in all of the above fields!',
                    'time' => time()
                ]
            );
            return $resultJson;
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

            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            if ($apiConnectionStatusCode === 200) {
                return $resultJson->setData(['success' => true, 'time' => time()]);
            }

            return $resultJson->setData(['success' => false, 'error_message' => $statusMessage, 'time' => time()]);

        } catch (\Exception $e) {
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            return $resultJson->setData(['success' => false, 'error_message' => $e->getMessage(), 'time' => time()]);
        }
    }

    protected function _isAllowed()
    {
        return true;
    }
}
