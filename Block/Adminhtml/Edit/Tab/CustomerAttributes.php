<?php

namespace Commerce365\Core\Block\Adminhtml\Edit\Tab;

use Commerce365\Core\Block\Adminhtml\CustomerAttributeList;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Framework\Phrase;
use Magento\Ui\Component\Layout\Tabs\TabInterface;

class CustomerAttributes extends Generic implements TabInterface
{
    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    public function getTabLabel(): Phrase
    {
        return __('Commerce 365 label');
    }

    public function getTabTitle(): Phrase
    {
        return __('Commerce 365');
    }

    public function canShowTab(): bool
    {
        if ($this->getCustomerId()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
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
    public function getTabClass(): string
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
        return '';
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
        return $this->getLayout()
          ->createBlock(CustomerAttributeList::class)
          ->setTemplate('Commerce365_Core::tab/view/customer_attribute_list.phtml')
          ->toHtml();
    }
}
