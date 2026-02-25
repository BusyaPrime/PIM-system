<?php

declare(strict_types=1);

namespace App\Enrichment\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;

class CompletenessRule extends AggregateRoot
{
    private string $id;
    private string $familyId;
    private string $attributeId;
    private ?string $channel;
    /** @var array<string> List of locales this rule applies to */
    private array $locales;
    private bool $isRequired;

    public function __construct(
        string $id,
        string $familyId,
        string $attributeId,
        ?string $channel = null,
        array $locales = [],
        bool $isRequired = true
    ) {
        $this->id          = $id;
        $this->familyId    = $familyId;
        $this->attributeId = $attributeId;
        $this->channel     = $channel;
        $this->locales     = $locales;
        $this->isRequired  = $isRequired;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFamilyId(): string
    {
        return $this->familyId;
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    /**
     * @return array<string>
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }
}
