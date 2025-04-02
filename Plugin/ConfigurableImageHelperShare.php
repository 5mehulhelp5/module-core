<?php

declare(strict_types=1);

namespace Commerce365\Core\Plugin;

use Commerce365\Core\Model\MainConfig;
use Commerce365\Core\Service\Product\GetParentProduct;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product;

class ConfigurableImageHelperShare
{
    public function __construct(
        private readonly GetParentProduct $getParentProduct,
        private readonly MainConfig $mainConfig,
    ) {}

    /**
     * @param Image $subject
     * @param Product $product
     * @param string $imageId
     * @param array $attributes
     * @return array
     */
    public function beforeInit(Image $subject, $product, $imageId, $attributes = []): array
    {
        if (!$this->mainConfig->isConfigurableImageEnabled()) {
            return [$product, $imageId, $attributes];
        }

        if (!$product || $product->getTypeId() !== 'simple') {
            return [$product, $imageId, $attributes];
        }

        // Check if the simple product has an image (other than placeholder)
        $hasImage = $product->getImage() && $product->getImage() !== 'no_selection';

        // If the product has its own image and we're not replacing, use the original image
        if ($hasImage && !$this->mainConfig->isConfigurableImageReplaceExisting()) {
            return [$product, $imageId, $attributes];
        }

        // Get parent configurable product
        $parentProduct = $this->getParentProduct->execute($product);

        if (!$parentProduct) {
            return [$product, $imageId, $attributes];
        }

        return [$parentProduct, $imageId, $attributes];
    }
}
