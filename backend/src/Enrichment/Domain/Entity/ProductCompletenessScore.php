<?php

declare(strict_types=1);

namespace App\Enrichment\Domain\Entity;

class ProductCompletenessScore
{
    private string $id;
    private string $productId;
    private ?string $channel;
    private ?string $locale;
    private float $ratio; // от 0.0 до 100.0 (процент заполненности)
    private \DateTimeImmutable $calculatedAt;

    public function __construct(
        string $id,
        string $productId,
        ?string $channel,
        ?string $locale,
        float $ratio
    ) {
        $this->id           = $id;
        $this->productId    = $productId;
        $this->channel      = $channel;
        $this->locale       = $locale;
        $this->ratio        = $ratio;
        $this->calculatedAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getRatio(): float
    {
        return $this->ratio;
    }

    public function getCalculatedAt(): \DateTimeImmutable
    {
        return $this->calculatedAt;
    }
}
