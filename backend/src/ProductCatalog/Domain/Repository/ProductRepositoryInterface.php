<?php

declare(strict_types=1);

namespace App\ProductCatalog\Domain\Repository;

use App\ProductCatalog\Domain\Entity\Product;
use App\ProductCatalog\Domain\ValueObject\ProductId;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;
    
    public function findById(ProductId $id): ?Product;
}
