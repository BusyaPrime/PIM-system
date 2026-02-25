<?php

declare(strict_types=1);

namespace App\Attributes\Domain\Entity\Value;

class TextAttributeValue extends AbstractAttributeValue
{
    private string $value;

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
