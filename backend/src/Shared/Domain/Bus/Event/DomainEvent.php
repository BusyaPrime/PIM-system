<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

abstract class DomainEvent
{
    private string $eventId;
    private string $occurredOn;

    public function __construct(
        private readonly string $aggregateId,
        ?string $eventId = null,
        ?string $occurredOn = null
    ) {
        $this->eventId    = $eventId ?: \Ramsey\Uuid\Uuid::uuid4()->toString();
        $this->occurredOn = $occurredOn ?: (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM);
    }

    abstract public static function eventName(): string;

    /**
     * @return array<string, mixed>
     */
    abstract public function toPrimitives(): array;

    /**
     * @param array<string, mixed> $body
     */
    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
