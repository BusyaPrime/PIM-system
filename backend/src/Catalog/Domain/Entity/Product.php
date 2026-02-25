<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;

class Product extends AggregateRoot
{
    private string $id;
    private string $identifier; // Главный уникальный идентификатор (он же SKU)
    private ?string $familyId;
    private bool $isEnabled;
    private \DateTimeImmutable $created;
    private \DateTimeImmutable $updated;

    public function __construct(string $id, string $identifier, ?string $familyId = null)
    {
        $this->id         = $id;
        $this->identifier = $identifier;
        $this->familyId   = $familyId;
        $this->isEnabled  = false;
        $this->created    = new \DateTimeImmutable();
        $this->updated    = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getFamilyId(): ?string
    {
        return $this->familyId;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function enable(): void
    {
        $this->isEnabled = true;
        // @todo кидаем ивент ProductEnabledDomainEvent
    }

    public function disable(): void
    {
        $this->isEnabled = false;
        // @todo кидаем ивент ProductDisabledDomainEvent
    }

    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdated(): \DateTimeImmutable
    {
        return $this->updated;
    }
}
