<?php

namespace Commerce365\Core\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{
    private $customerSetupFactory;
    private $c365Helper;
    private $eavSetupFactory;

    public function __construct(CustomerSetupFactory $customerSetupFactory, \Commerce365\Core\Helper\Data $helper, EavSetupFactory $eavSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->c365Helper = $helper;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->c365Helper->LogInfo('Commerce 365 Configuration Module - Install data (intial)');
        //$this->cleanup($setup);

        $this->c365Helper->LogEmergency('Testing the logging mechanism: Emergency');
        $this->c365Helper->LogCritical('Testing the logging mechanism: Critical');
        $this->c365Helper->LogError('Testing the logging mechanism: Error', ['param1' => 'value1']);
        $this->c365Helper->LogWarning('Testing the logging mechanism: Warning');
        $this->c365Helper->LogInfo('Testing the logging mechanism: Info');
        $this->c365Helper->LogDebug('Testing the logging mechanism: Debug');
    }

    private function cleanup(ModuleDataSetupInterface $setup)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_customer_no');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_company_name');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_customer_price_group');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_customer_discount_group');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_payment_terms_code');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_payment_method_code');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_shipment_method_code');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_shipment_agent_code');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_shipment_agent_service_code');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_location_code');
        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bc_blocked_code');

        $this->c365Helper->LogInfo('Removed existing customer custom attributes');
    }
}
