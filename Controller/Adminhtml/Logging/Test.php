<?php

namespace Commerce365\Core\Controller\Adminhtml\Logging;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Test extends Action
{
    protected $_c365Helper;

    public function __construct(
        \Commerce365\Core\Helper\Data $c365Helper,
        Context $context
    ) {
        $this->_c365Helper = $c365Helper;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $this->_c365Helper->LogEmergency('This is an emergency');
            $this->_c365Helper->LogCritical('This is critical');
            $this->_c365Helper->LogError('This is an error');
            $this->_c365Helper->LogWarning('This is a warning');
            $this->_c365Helper->LogInfo('This is just information');
            $this->_c365Helper->LogDebug('This is for debugging');

            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $resultJson->setData(['success' => true, 'time' => time()]);

            return $resultJson;
        } catch (\Exception $e) {
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $resultJson->setData(['success' => false, 'error_message' => $e->getMessage(), 'time' => time()]);
            return $resultJson;
        }
    }

    protected function _isAllowed(): bool
    {
        return true;
    }
}
