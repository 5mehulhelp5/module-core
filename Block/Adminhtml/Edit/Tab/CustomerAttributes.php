<?php

namespace Commerce365\Core\Block\Adminhtml\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Ui\Component\Layout\Tabs\TabInterface;

class CustomerAttributes extends Generic implements TabInterface
{
    protected $_coreRegistry;
    protected $_systemStore;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }
    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Commerce 365 label');
    }
    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Commerce 365');
    }
    /**
     * @return bool
     */
    public function canShowTab()
    {
        if ($this->getCustomerId()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        if ($this->getCustomerId()) {
            return false;
        }
        return true;
    }
    /**
     * Tab class getter
     *
     * @return string
     */
    public function getTabClass()
    {
        return '';
    }
    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl()
    {
        //replace the tab with the url you want
        return '';
        //return $this->getUrl('test/*/test', ['_current' => true]);
    }
    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded()
    {
        return false;
    }

    protected function _toHtml()
    {
        if ($this->canShowTab()) {
            return $this->getFormHtml();
        }

        return '';
    }

    public function getFormHtml()
    {
        $html = $this->getLayout()
          ->createBlock('Commerce365\Core\Block\Adminhtml\CustomerAttributeList')
          ->setTemplate('Commerce365_Core::tab/view/customer_attribute_list.phtml')
          ->toHtml();

        return $html;
    }
}
