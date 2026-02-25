<?php

declare(strict_types=1);

namespace App\Search\Domain\Document;

/**
 * Represents a denormalized Product document ready for Elasticsearch ingestion.
 */
class ProductDocument
{
    private string $id;
    private string $sku;
    private array $attributes;
    private array $categories;
    private string $family;
    private bool $isActive;
    private ?\DateTimeImmutable $updatedAt;

    public function __construct(string $id, string $sku)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->attributes = [];
        $this->categories = [];
        $this->isActive = false;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    public function setFamily(string $family): void
    {
        $this->family = $family;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'attributes' => $this->attributes,
            'categories' => $this->categories,
            'family' => $this->family ?? null,
            'is_active' => $this->isActive,
            'updated_at' => $this->updatedAt?->format(\DateTimeInterface::ATOM),
        ];
    }
}
