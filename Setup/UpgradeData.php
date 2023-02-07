<?php

namespace Commerce365\Core\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    private $customerSetupFactory;
    private $eavSetupFactory;
    private $c365Helper;

    public function __construct(CustomerSetupFactory $customerSetupFactory, EavSetupFactory $eavSetupFactory, \Commerce365\Core\Helper\Data $helper)
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->c365Helper = $helper;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $this->c365Helper->LogInfo('Commerce 365 Configuration Module - Upgrade data');

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $this->CheckAndCreateCustomerAttribute($setup, 'bc_customer_no', 'BC Customer Number', 'varchar', 'text', 300, false, '', true);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_company_name', 'Company Name', 'varchar', 'text', 305, false);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_customer_price_group', 'Customer Price Group', 'varchar', 'text', 310, false);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_customer_discount_group', 'Customer Discount Group', 'varchar', 'text', 311, false);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_payment_terms_code', 'Payment Terms Code', 'varchar', 'text', 320, false);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_payment_method_code', 'Payment Method Code', 'varchar', 'text', 321, false);

        $this->CheckAndCreateCustomerAttribute($setup, 'bc_shipment_method_code', 'Shipment Method Code', 'varchar', 'text', 322, false);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_shipment_agent_code', 'Shipment Method Agent Code', 'varchar', 'text', 323, false);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_shipment_agent_service_code', 'Shipment Agent Service Code', 'varchar', 'text', 324, false);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_location_code', 'Location Code', 'varchar', 'text', 325, false);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_blocked_code', 'Blocked Code', 'varchar', 'text', 326, false);

        $this->c365Helper->LogInfo('Commerce 365 Configuration Module - Upgrade data finished');
        $this->c365Helper->LogInfo('Good to see that you have upgraded. You are now running version 2.0.0 of the Commerce 365 M2 Configuration Module');

        //update the bc_customer_no field to make it work properly in the admin grid
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->updateAttribute(\Magento\Customer\Model\Customer::ENTITY,'bc_customer_no',
            [
                'visible' => true,
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true
            ]);
    }

    private function CheckAndCreateCustomerAttribute(ModuleDataSetupInterface $setup, string $attributeCode, string $label, string $type, string $input, int $position = 500, bool $visible = false, string $source = '', bool $usedInGrid = false)
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        if ($customerSetup->getAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode) == false) {
            $this->c365Helper->LogInfo('Customer attribute ' . $attributeCode . ' does not exist. Creating..');

            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode, [
                'type' => $type,
                'label' => $label,
                'input' => $input,
                'source' => $source,
                'required' => false,
                'visible' => $visible,
                'position' => $position,
                'system' => false,
                'backend' => '',
                'is_used_in_grid'       => $usedInGrid,
                'is_visible_in_grid'    => $usedInGrid
            ]);

            $attribute = $customerSetup->getEavConfig()->getAttribute('customer', $attributeCode)
                ->addData(['used_in_forms' => [
                    'adminhtml_customer'
                ]]);
            $attribute->save();

            $this->c365Helper->LogInfo('Done!');
        } else {
            $this->c365Helper->LogInfo('Attribute with code: ' . $attributeCode . ' already exists! Run clean method first in case you want to update.');
        }
    }
}
