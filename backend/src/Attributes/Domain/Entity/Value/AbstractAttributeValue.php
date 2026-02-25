<?php

declare(strict_types=1);

namespace App\Attributes\Domain\Entity\Value;

use App\Attributes\Domain\Entity\Attribute;

abstract class AbstractAttributeValue
{
    private string $id;
    private Attribute $attribute;
    private string $productId; // Жестко линкуем это значение к конкретному продукту
    private ?string $locale;
    private ?string $channel;

    public function __construct(
        string $id,
        Attribute $attribute,
        string $productId,
        ?string $locale = null,
        ?string $channel = null
    ) {
        if ($attribute->isLocalizable() && $locale === null) {
            throw new \InvalidArgumentException('Locale is required for localizable attributes.');
        }

        if ($attribute->isScopable() && $channel === null) {
            throw new \InvalidArgumentException('Channel is required for scopable attributes.');
        }

        $this->id        = $id;
        $this->attribute = $attribute;
        $this->productId = $productId;
        $this->locale    = $locale;
        $this->channel   = $channel;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAttribute(): Attribute
    {
        return $this->attribute;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    abstract public function getValue(): mixed;
}
