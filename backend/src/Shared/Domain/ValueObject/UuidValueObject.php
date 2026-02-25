<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class UuidValueObject extends StringValueObject
{
    protected function ensureIsValid(string $value): void
    {
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value)) {
            throw new \InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $value));
        }
    }
}
