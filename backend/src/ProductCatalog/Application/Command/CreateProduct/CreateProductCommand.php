<?php

declare(strict_types=1);

namespace App\ProductCatalog\Application\Command\CreateProduct;

use App\Shared\Application\Command\CommandInterface;

final class CreateProductCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $sku,
        public readonly string $name,
    ) {
    }
}
