<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Request\BusinessCentral;

use Commerce365\Core\Model\AdvancedConfig;
use Commerce365\Core\Service\Logger;
use Commerce365\Core\Service\Request\PostInterface;
use Commerce365\Core\Service\Response\BusinessCentral\ProcessResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BasicPost implements PostInterface
{
    private ProcessResponse $processResponse;
    private AdvancedConfig $advancedConfig;
    private Logger $logger;

    public function __construct(
        AdvancedConfig $advancedConfig,
        ProcessResponse $processResponse,
        Logger $logger
    ) {
        $this->processResponse = $processResponse;
        $this->advancedConfig = $advancedConfig;
        $this->logger = $logger;
    }

    public function execute($method, $postData = []): array
    {
        $endpointUrl = $this->prepareUrl($method);
        if (!$endpointUrl) {
            return [];
        }

        $username = $this->advancedConfig->getUsername();
        $password = $this->advancedConfig->getPassword();

        $postData['json'] = $this->processJsonParams($postData['json']);
        $postData['auth'] = [$username, $password];

        try {
            $response = $this->makeCall($endpointUrl, $postData);
        } catch (GuzzleException $exception) {
            $this->logger->error($exception->getMessage());
            return [];
        }

        return $this->processResponse->execute($response);
    }

    /**
     * @throws GuzzleException
     */
    private function makeCall($endpointUrl, $postData)
    {
        $client = new Client([
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/json'
            ]
        ]);

        return $client->post($endpointUrl, $postData);
    }

    private function prepareUrl(string $method): string
    {
        $endpoint = $this->advancedConfig->getEndpoint();
        $company = $this->advancedConfig->getCompany();

        return rtrim($endpoint, '/') . '/BC/ODataV4/' . $method . '?company=' . rawurlencode($company);
    }

    private function processJsonParams(array $jsonData): array
    {
        foreach ($jsonData as $key => $param) {
            if (is_array($param)) {
                $jsonData[$key] = '[' . implode(',', $param) . ']';
            }
        }

        return $jsonData;
    }
}
