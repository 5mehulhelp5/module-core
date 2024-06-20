<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Customer;

class GetParentCustomerId
{
    public function __construct(private readonly GetParentCustomer $getParentCustomer) {}

    public function execute($customerId)
    {
        $parentCustomer = $this->getParentCustomer->getByCustomerId($customerId);

        return $parentCustomer ? $parentCustomer->getId() : $customerId;
    }
}
