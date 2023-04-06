<?php

declare(strict_types=1);

namespace Commerce365\Core\Service;

use Commerce365\Core\Model\MainConfig;
use Commerce365\Core\Service\Customer\ParentResolveCustomerSession;
use Magento\Customer\Model\Session;

class PrepareSalesRequestQuery
{
    private MainConfig $mainConfig;
    private Session $customerSession;

    public function __construct(MainConfig $mainConfig, ParentResolveCustomerSession $customerSession)
    {
        $this->mainConfig = $mainConfig;
        $this->customerSession = $customerSession;
    }
    public function execute(array $query)
    {
        $query['customerId'] = $this->customerSession->getCustomer()->getId();

        //config returns 0 or 1, but we need false or true for our querystring parameter
        $query['webOrdersOnly'] = true;
        if ($this->mainConfig->getIncludeNonWebOrders()) {
            $query['webOrdersOnly'] = false;
        }

        $query['releasedOnly'] = true;

        return $query;
    }
}
