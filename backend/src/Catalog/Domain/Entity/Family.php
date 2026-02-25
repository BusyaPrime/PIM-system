<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;

class Family extends AggregateRoot
{
    private string $id;
    private string $code;
    /** @var array<string> List of Attribute IDs belonging to this family */
    private array $attributeIds;

    public function __construct(string $id, string $code, array $attributeIds = [])
    {
        $this->id           = $id;
        $this->code         = $code;
        $this->attributeIds = $attributeIds;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return array<string>
     */
    public function getAttributeIds(): array
    {
        return $this->attributeIds;
    }
}
