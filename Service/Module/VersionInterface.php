<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Module;

interface VersionInterface
{
    public function getVersion(): string;

    public function getModuleName(): ?string;

    public function getPackageName(): string;

    public function getLabelName(): ?string;
}
