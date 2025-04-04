<?php

declare(strict_types=1);

namespace Commerce365\Core\Plugin;

use Commerce365\Core\Model\MainConfig;
use Commerce365\Core\Service\Product\GetParentProduct;
use Magento\Catalog\Model\Product;
use Magento\Framework\Data\Collection;

class ConfigurableGalleryImagesShare
{
    public function __construct(
        private readonly GetParentProduct $getParentProduct,
        private readonly MainConfig $mainConfig
    ) {}

    /**
     * @param Product $subject
     * @param Collection $result
     * @return Collection
     */
    public function afterGetMediaGalleryImages(Product $subject, Collection $result): Collection
    {
        if (!$this->mainConfig->isConfigurableImageEnabled()) {
            return $result;
        }

        if ($subject->getTypeId() !== 'simple') {
            return $result;
        }

        // Check if the simple product has an image (other than placeholder)
        $hasImage = $subject->getImage() && $subject->getImage() !== 'no_selection';

        // If the product has its own image and we're not replacing, use the original image
        if ($hasImage && !$this->mainConfig->isConfigurableImageReplaceExisting()) {
            return $result;
        }

        $parentProduct = $this->getParentProduct->execute($subject);

        if (!$parentProduct) {
            return $result;
        }

        return $parentProduct->getMediaGalleryImages();
    }
}
