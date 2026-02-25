<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

/**
 * Marker interface for all Domain Events in the system.
 */
interface DomainEvent
{
    public function getOccurredOn(): \DateTimeImmutable;
}
