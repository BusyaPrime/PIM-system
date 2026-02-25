<?php

declare(strict_types=1);

namespace App\Attributes\Domain\Entity\Value;

class NumberAttributeValue extends AbstractAttributeValue
{
    private float $value;

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
