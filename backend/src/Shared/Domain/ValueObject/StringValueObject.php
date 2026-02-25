<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class StringValueObject
{
    public function __construct(protected readonly string $value)
    {
        $this->ensureIsValid($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value();
    }

    abstract protected function ensureIsValid(string $value): void;
}
