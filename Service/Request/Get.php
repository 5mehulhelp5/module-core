<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Request;

use Commerce365\Core\Service\Response\ProcessResponse;
use GuzzleHttp\Exception\GuzzleException;

class Get
{
    private ProcessResponse $processResponse;
    private GetClient $getClient;

    /**
     * @param GetClient $getClient
     * @param ProcessResponse $processResponse
     */
    public function __construct(
        GetClient $getClient,
        ProcessResponse $processResponse
    ) {
        $this->processResponse = $processResponse;
        $this->getClient = $getClient;
    }

    /**
     * @throws GuzzleException
     */
    public function execute($endpoint, $query): array
    {
        $client = $this->getClient->execute();

        if (!$client) {
            return [];
        }

        $response = $client->get($endpoint, ['query' => $query]);

        return $this->processResponse->execute($response);
    }
}
