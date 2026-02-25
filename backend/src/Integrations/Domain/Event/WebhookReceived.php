<?php

declare(strict_types=1);

namespace App\Integrations\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;

class WebhookReceived implements DomainEvent
{
    private string $sourceSystem;
    private string $eventType;
    private array $payload;
    private array $headers;
    private \DateTimeImmutable $occurredOn;

    public function __construct(string $sourceSystem, string $eventType, array $payload, array $headers = [])
    {
        $this->sourceSystem = $sourceSystem;
        $this->eventType = $eventType;
        $this->payload = $payload;
        $this->headers = $headers;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function getSourceSystem(): string
    {
        return $this->sourceSystem;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getOccurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
