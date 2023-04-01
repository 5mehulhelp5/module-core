<?php

namespace Commerce365\Core\Setup;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    private CustomerSetupFactory $customerSetupFactory;

    public function __construct(CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_customer_no', 'BC Customer Number', 'varchar', 'text', 300, false, '', true);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_company_name', 'Company Name', 'varchar', 'text', 305);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_customer_price_group', 'Customer Price Group', 'varchar', 'text', 310);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_customer_discount_group', 'Customer Discount Group', 'varchar', 'text', 311);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_payment_terms_code', 'Payment Terms Code', 'varchar', 'text', 320);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_payment_method_code', 'Payment Method Code', 'varchar', 'text', 321);

        $this->CheckAndCreateCustomerAttribute($setup, 'bc_shipment_method_code', 'Shipment Method Code', 'varchar', 'text', 322);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_shipment_agent_code', 'Shipment Method Agent Code', 'varchar', 'text', 323);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_shipment_agent_service_code', 'Shipment Agent Service Code', 'varchar', 'text', 324);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_location_code', 'Location Code', 'varchar', 'text', 325);
        $this->CheckAndCreateCustomerAttribute($setup, 'bc_blocked_code', 'Blocked Code', 'varchar', 'text', 326);
    }

    private function CheckAndCreateCustomerAttribute(ModuleDataSetupInterface $setup, string $attributeCode, string $label, string $type, string $input, int $position = 500, bool $visible = false, string $source = '', bool $usedInGrid = false)
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        if ($customerSetup->getAttribute(Customer::ENTITY, $attributeCode)) {
            return;
        }

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(Customer::ENTITY, $attributeCode, [
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
    }
}
