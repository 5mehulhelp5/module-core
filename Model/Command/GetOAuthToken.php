<?php

declare(strict_types=1);

namespace Commerce365\Core\Model\Command;

use Magento\Framework\App\ResourceConnection;

class GetOAuthToken
{
    private ResourceConnection $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function execute()
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('commerce365_oauth_token');
        $select = $connection->select()->from($tableName, ['token'])->limit(1);

        return $connection->fetchOne($select);
    }
}
