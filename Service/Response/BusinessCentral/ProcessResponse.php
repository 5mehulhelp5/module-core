<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Response\BusinessCentral;

use Magento\Framework\Serialize\SerializerInterface;

class ProcessResponse
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $response
     * @return array|bool|float|int|string|null
     */
    public function execute($response)
    {
        $responseData = [];
        $status = $response->getStatusCode();
        if ($status >= 200 && $status < 300) {
            $responseData = $this->serializer->unserialize($response->getBody()->getContents());
            $responseData = $this->serializer->unserialize($responseData['value']);
        }

        return $responseData;
    }
}
