<?php

declare(strict_types=1);

namespace App\ProductCatalog\Domain\Entity;

use App\ProductCatalog\Domain\Event\ProductCreatedDomainEvent;
use App\ProductCatalog\Domain\ValueObject\ProductId;
use App\ProductCatalog\Domain\ValueObject\ProductSku;
use App\Shared\Domain\AggregateRoot;

final class Product extends AggregateRoot
{
    private function __construct(
        private ProductId $id,
        private ProductSku $sku,
        private string $name
    ) {
    }

    public static function create(ProductId $id, ProductSku $sku, string $name): self
    {
        $product = new self($id, $sku, $name);
        
        $product->record(new ProductCreatedDomainEvent(
            $id->value(),
            $sku->value(),
            $name
        ));

        return $product;
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function sku(): ProductSku
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }
}
