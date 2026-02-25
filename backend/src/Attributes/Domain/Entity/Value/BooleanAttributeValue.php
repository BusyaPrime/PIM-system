<?php

declare(strict_types=1);

namespace App\Attributes\Domain\Entity\Value;

class BooleanAttributeValue extends AbstractAttributeValue
{
    private bool $value;

    public function setValue(bool $value): void
    {
        $this->value = $value;
    }

    public function getValue(): bool
    {
        return $this->value;
    }
}
