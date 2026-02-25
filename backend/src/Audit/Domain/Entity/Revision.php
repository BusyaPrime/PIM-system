<?php

declare(strict_types=1);

namespace App\Audit\Domain\Entity;

class Revision
{
    private string $id;
    private string $entityType; // Тип сущности, которую ковыряли (например, "Product", "Category")
    private string $entityId;
    private string $userId; // ID юзера, который навел суету (инициировал изменение)
    private string $action; // Че сделал: Created, Updated, Deleted
    private array $changes; // Тут лежит JSON дифф или полный слепок стейта
    private \DateTimeImmutable $timestamp;

    public function __construct(
        string $id,
        string $entityType,
        string $entityId,
        string $userId,
        string $action,
        array $changes
    ) {
        $this->id = $id;
        $this->entityType = $entityType;
        $this->entityId = $entityId;
        $this->userId = $userId;
        $this->action = $action;
        $this->changes = $changes;
        $this->timestamp = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEntityType(): string
    {
        return $this->entityType;
    }

    public function getEntityId(): string
    {
        return $this->entityId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getChanges(): array
    {
        return $this->changes;
    }

    public function getTimestamp(): \DateTimeImmutable
    {
        return $this->timestamp;
    }
}
