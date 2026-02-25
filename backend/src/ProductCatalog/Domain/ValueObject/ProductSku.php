<?php

declare(strict_types=1);

namespace App\ProductCatalog\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

final class ProductSku extends StringValueObject
{
    protected function ensureIsValid(string $value): void
    {
        if (strlen($value) < 3 || strlen($value) > 20) {
            throw new \InvalidArgumentException('Product SKU must be between 3 and 20 characters.');
        }
        if (!preg_match('/^[A-Z0-9\-]+$/', $value)) {
            throw new \InvalidArgumentException('Product SKU can only contain uppercase letters, numbers, and hyphens.');
        }
    }
}
