<?php

declare(strict_types=1);

namespace Commerce365\Core\Model\Command;

use Magento\Framework\App\ResourceConnection;

class SaveOAuthToken
{
    private ResourceConnection $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function execute($token): void
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('commerce365_oauth_token');
        $connection->truncateTable($tableName);
        $connection->insert($tableName, ['token' => $token]);
    }
}
