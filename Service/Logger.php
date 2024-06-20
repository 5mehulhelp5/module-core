<?php

declare(strict_types=1);

namespace Commerce365\Core\Service;

use Psr\Log\LoggerInterface;

class Logger
{
    public function __construct(private readonly LoggerInterface $logger) {}

    public function error(string $message)
    {
        $this->logger->error($message);
    }
}
