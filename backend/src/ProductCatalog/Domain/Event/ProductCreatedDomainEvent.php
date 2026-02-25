<?php

declare(strict_types=1);

namespace App\ProductCatalog\Domain\Event;

use App\Shared\Domain\DomainEventInterface;

final class ProductCreatedDomainEvent implements DomainEventInterface
{
    private \DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly string $productId,
        public readonly string $sku,
        public readonly string $name
    ) {
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function getOccurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
