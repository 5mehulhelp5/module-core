<?php

namespace Commerce365\Core\Block\Adminhtml\System\Config\Buttons;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class TestLogging extends Field
{
    protected $_template = 'Commerce365_Core::system/config/buttons/testlogging.phtml';

    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

        return parent::render($element);
    }

    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }

    public function getAjaxUrl(): string
    {
        return $this->getUrl('commerce365_configuration/logging/test');
    }

    public function getButtonHtml()
    {
        $data = [
            'id'    => 'testlogging_button',
            'label' => __('Run logging test'),
        ];

        /** @var \Magento\Backend\Block\Widget\Button $button */
        $button = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')->setData($data);
        $button->setDataAttribute(
            [
                'mage-init' => '{"Commerce365_Core/js/system/config/buttons/testlogging": {
                            "submitUrl":"' . $this->getAjaxUrl() . '"
                        }
                    }',
            ]
        );

        return $button->toHtml();
    }
}
