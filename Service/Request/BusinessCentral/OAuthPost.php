<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Request\BusinessCentral;

use Commerce365\Core\Model\AdvancedConfig;
use Commerce365\Core\Model\Command\GetOAuthToken;
use Commerce365\Core\Service\Response\BusinessCentral\ProcessResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class OAuthPost
{
    private ProcessResponse $processResponse;
    private AdvancedConfig $advancedConfig;
    private RefreshOAuthToken $refreshOAuthToken;
    private GetOAuthToken $getOAuthToken;

    public function __construct(
        AdvancedConfig $advancedConfig,
        ProcessResponse $processResponse,
        RefreshOAuthToken $refreshOAuthToken,
        GetOAuthToken $getOAuthToken
    ) {
        $this->processResponse = $processResponse;
        $this->advancedConfig = $advancedConfig;
        $this->refreshOAuthToken = $refreshOAuthToken;
        $this->getOAuthToken = $getOAuthToken;
    }

    public function execute($method, $postData = [], $take = 1): array
    {
        $endpointUrl = $this->prepareUrl($method);
        if (!$endpointUrl) {
            return [];
        }

        $postData['json'] = $this->processJsonParams($postData['json']);

        $token = $this->getOAuthToken->execute();
        if (!$token) {
            $token = $this->refreshOAuthToken->execute();
        }

        if (!$token) {
            return [];
        }

        $response = $this->makeCall($endpointUrl, $token, $postData);

        return $this->processResponse->execute($response);
    }

    private function makeCall($endpointUrl, $token, $postData, $take = 1)
    {
        $client = new Client([
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        try {
            return $client->post($endpointUrl, $postData);
        } catch (ClientException $exception) {
            if ($exception->getCode() === 401 && $take !== 2) {
                $token = $this->refreshOAuthToken->execute();
                $this->makeCall($endpointUrl, $token, $postData, 2);
            }
        }
    }

    private function prepareUrl(string $method): string
    {
        $tenantId = $this->advancedConfig->getTenantId();
        if (!$tenantId) {
            return '';
        }

        $endpoint = $this->advancedConfig->getEndpoint();
        $company = $this->advancedConfig->getCompany();

        return rtrim($endpoint, '/') . '/' . $tenantId . '/Demo/ODataV4/' . $method . '?company=' . rawurlencode($company);
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
