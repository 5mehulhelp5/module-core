<?php

declare(strict_types=1);

namespace Commerce365\Core\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCustomerCompanyAttributes implements DataPatchInterface
{
    private EavSetupFactory $setupFactory;
    private ModuleDataSetupInterface $moduleDataSetup;
    private Config $eavConfig;

    public function __construct(
        EavSetupFactory $setupFactory,
        ModuleDataSetupInterface $moduleDataSetup,
        Config $eavConfig
    ) {
        $this->setupFactory = $setupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavConfig = $eavConfig;
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function apply()
    {
        $this->createAttribute('bc_contact_no', 'BC Contact Number');
        $this->createAttribute('parent_customer_id', 'Parent Customer ID for Contacts');
    }

    private function createAttribute($code, $label)
    {
        $eavSetup = $this->setupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'parent_customer_id',
            [
                'type' => 'varchar',
                'label' => 'Parent Customer ID for Contacts',
                'input' => 'text',
                'required' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'position' => 300,
                'system' => false,
                'visible' => false
            ]
        );

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'parent_customer_id');

        if ($attribute) {
            $attribute->setData('used_in_forms', ['adminhtml_customer'])->save();
        }
    }
}
