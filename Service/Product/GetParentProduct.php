<?php

declare(strict_types=1);

namespace Commerce365\Core\Service\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class GetParentProduct
{
    /**
     * @var array
     */
    private array $parentProductCache = [];

    public function __construct(
        private readonly Configurable $configurableType,
        private readonly ProductRepositoryInterface $productRepository
    ) {}

    /**
     * Get parent configurable product
     *
     * @param Product $product
     * @return ProductInterface|null
     */
    public function execute(Product $product): ?ProductInterface
    {
        $productId = $product->getId();

        // Return from cache if available
        if (isset($this->parentProductCache[$productId])) {
            return $this->parentProductCache[$productId];
        }

        // Get configurable parent products
        $parentIds = $this->configurableType->getParentIdsByChild($productId);

        if (empty($parentIds)) {
            return null;
        }

        try {
            // Get the first parent product
            $parentId = reset($parentIds);
            $parentProduct = $this->productRepository->getById($parentId);

            // Store in cache
            $this->parentProductCache[$productId] = $parentProduct;

            return $parentProduct;
        } catch (\Exception $e) {
            return null;
        }
    }
}
