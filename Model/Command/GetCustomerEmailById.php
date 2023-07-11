<?php

declare(strict_types=1);

namespace Commerce365\Core\Model\Command;

use Magento\Framework\App\ResourceConnection;

class GetCustomerEmailById
{
    private ResourceConnection $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param $customerId
     * @return string
     */
    public function execute($customerId)
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('customer_entity');
        $select = $connection->select()->from($tableName, ['email'])
            ->where('entity_id = ?', $customerId);

        return $connection->fetchOne($select);
    }
}
