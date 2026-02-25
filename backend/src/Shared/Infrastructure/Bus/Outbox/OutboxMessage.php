<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Outbox;

use App\Shared\Domain\Bus\Event\DomainEvent;

class OutboxMessage
{
    private string $id;
    private string $eventType;
    private string $aggregateId;
    /** @var array<string, mixed> */
    private array $payload;
    private \DateTimeImmutable $occurredOn;

    public function __construct(
        string $id,
        string $eventType,
        string $aggregateId,
        array $payload,
        \DateTimeImmutable $occurredOn
    ) {
        $this->id          = $id;
        $this->eventType   = $eventType;
        $this->aggregateId = $aggregateId;
        $this->payload     = $payload;
        $this->occurredOn  = $occurredOn;
    }

    public static function fromDomainEvent(DomainEvent $event): self
    {
        return new self(
            id: $event->eventId(),
            eventType: $event::eventName(),
            aggregateId: $event->aggregateId(),
            payload: $event->toPrimitives(),
            occurredOn: new \DateTimeImmutable($event->occurredOn())
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    /**
     * @return array<string, mixed>
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getOccurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
