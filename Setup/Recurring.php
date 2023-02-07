<?php

namespace Commerce365\Core\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;

class Recurring implements InstallSchemaInterface
{
    private $customerSetupFactory;
    private $c365Helper;

    public function __construct(\Commerce365\Core\Helper\Data $helper) {
        $this->c365Helper = $helper;
    }

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $this->c365Helper->LogInfo('Commerce 365 Configuration Module - Recurring install');
        $this->c365Helper->LogInfo('You are currently running version ' . $context->getVersion() . ' of the Commerce 365 M2 Configuration Module');

        $this->c365Helper->LogEmergency('Testing the logging mechanism: Emergency');
        $this->c365Helper->LogCritical('Testing the logging mechanism: Critical');
        $this->c365Helper->LogError('Testing the logging mechanism: Error', ['param1' => 'value1']);
        $this->c365Helper->LogWarning('Testing the logging mechanism: Warning');
        $this->c365Helper->LogInfo('Testing the logging mechanism: Info');
        $this->c365Helper->LogDebug('Testing the logging mechanism: Debug');

    }
}
