<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface DomainEventInterface
{
    public function getOccurredOn(): \DateTimeImmutable;
}
