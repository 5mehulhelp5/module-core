<?php

declare(strict_types=1);

namespace Commerce365\Core\Service;

use Psr\Log\LoggerInterface;

class Logger
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function error(string $message)
    {
        $this->logger->error($message);
    }
}
