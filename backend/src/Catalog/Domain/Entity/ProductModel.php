<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;

class ProductModel extends AggregateRoot
{
    private string $id;
    private string $code;
    private ?string $familyId;
    /** @var array<string> List of generic attribute codes (Variation Axes) */
    private array $variationAxis;

    public function __construct(string $id, string $code, ?string $familyId = null, array $variationAxis = [])
    {
        $this->id            = $id;
        $this->code          = $code;
        $this->familyId      = $familyId;
        $this->variationAxis = $variationAxis;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getFamilyId(): ?string
    {
        return $this->familyId;
    }

    /**
     * @return array<string>
     */
    public function getVariationAxis(): array
    {
        return $this->variationAxis;
    }
}
