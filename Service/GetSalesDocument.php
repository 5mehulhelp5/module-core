<?php

declare(strict_types=1);

namespace Commerce365\Core\Service;

use Commerce365\Core\Service\Request\Get;

class GetSalesDocument
{
    private Get $get;
    private PrepareSalesRequestQuery $prepareSalesRequestQuery;

    /**
     * @param Get $get
     * @param PrepareSalesRequestQuery $prepareSalesRequestQuery
     */
    public function __construct(Get $get, PrepareSalesRequestQuery $prepareSalesRequestQuery)
    {
        $this->get = $get;
        $this->prepareSalesRequestQuery = $prepareSalesRequestQuery;
    }

    public function execute(array $query)
    {
        $query = $this->prepareSalesRequestQuery->execute($query);

        return $this->get->execute('v2/SalesDocumentHistory/Get', $query);
    }
}
