<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Entity;

class ProductVariant extends Product
{
    private string $parentModelId;

    public function __construct(string $id, string $identifier, string $parentModelId, ?string $familyId = null)
    {
        parent::__construct($id, $identifier, $familyId);
        $this->parentModelId = $parentModelId;
    }

    public function getParentModelId(): string
    {
        return $this->parentModelId;
    }
}
