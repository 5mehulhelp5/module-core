<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Request\BusinessCentral;

use Commerce365\Core\Model\AdvancedConfig;
use Commerce365\Core\Service\Logger;
use Commerce365\Core\Service\Request\PostInterface;
use Commerce365\Core\Service\Response\BusinessCentral\ProcessResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class BasicPost implements PostInterface
{
    private ProcessResponse $processResponse;
    private AdvancedConfig $advancedConfig;
    private Logger $logger;
    private GetBCEndpointUrl $getBCEndpointUrl;

    public function __construct(
        AdvancedConfig $advancedConfig,
        ProcessResponse $processResponse,
        GetBCEndpointUrl $getBCEndpointUrl,
        Logger $logger
    ) {
        $this->processResponse = $processResponse;
        $this->advancedConfig = $advancedConfig;
        $this->logger = $logger;
        $this->getBCEndpointUrl = $getBCEndpointUrl;
    }

    public function execute($method, $postData = []): array
    {
        $endpointUrl = $this->getBCEndpointUrl->execute($method);
        if (!$endpointUrl) {
            return [];
        }

        $username = $this->advancedConfig->getUsername();
        $password = $this->advancedConfig->getPassword();

        $postData['json'] = $this->processJsonParams($postData['json']);
        $postData['auth'] = [$username, $password];

        try {
            $response = $this->makeCall($endpointUrl, $postData);
        } catch (GuzzleException|ClientException $exception) {
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

        try {
            return $client->post($endpointUrl, $postData);
        } catch (ClientException $exception) {
            $this->logger->error($exception->getMessage());
            return [];
        }
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
