<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Module;

use Magento\Framework\Module\PackageInfoFactory;
use Magento\Framework\Module\PackageInfo;

class Version implements VersionInterface
{
    private PackageInfo $packageInfo;
    private string $packageName;
    private string $labelName;

    /**
     * @param PackageInfoFactory $packageInfoFactory
     * @param string $packageName
     * @param string $labelName
     */
    public function __construct(PackageInfoFactory $packageInfoFactory, string $packageName, string $labelName = '')
    {
        $this->packageInfo = $packageInfoFactory->create();
        $this->packageName = $packageName;
        $this->labelName = $labelName;
    }

    public function getVersion(): string
    {
        return $this->packageInfo->getVersion($this->getModuleName());
    }

    public function getModuleName(): ?string
    {
        return $this->packageInfo->getModuleName($this->packageName);
    }

    public function getPackageName(): string
    {
        return $this->packageName;
    }

    public function getLabelName(): ?string
    {
        return $this->labelName;
    }
}
