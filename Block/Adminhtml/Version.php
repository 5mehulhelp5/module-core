<?php

namespace Commerce365\Core\Block\Adminhtml;

use Commerce365\Core\Service\Module\VersionInterface;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Exception\ValidatorException;

class Version extends Template implements RendererInterface
{
    protected $_template = 'Commerce365_Core::system/config/version.phtml';
    private VersionInterface $moduleVersion;

    /**
     * @param Context $context
     * @param VersionInterface $version
     */
    public function __construct(Context $context, VersionInterface $version)
    {
        parent::__construct($context);
        $this->moduleVersion = $version;
    }

    /**
     * @return array[]
     */
    public function getModuleVersionInfo(): array
    {
        return [
            $this->moduleVersion->getPackageName() => [
                'label' => $this->moduleVersion->getLabelName()?: $this->moduleVersion->getModuleName(),
                'version' => $this->moduleVersion->getVersion()
            ]
        ];
    }

    /**
     * @param AbstractElement $element
     * @return string
     * @throws ValidatorException
     */
    public function render(AbstractElement $element): string
    {
        return $this->fetchView($this->getTemplateFile());
    }
}
