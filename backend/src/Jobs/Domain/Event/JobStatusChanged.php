<?php

declare(strict_types=1);

namespace App\Jobs\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;

class JobStatusChanged implements DomainEvent
{
    private string $jobId;
    private string $newStatus;
    private \DateTimeImmutable $occurredOn;

    public function __construct(string $jobId, string $newStatus)
    {
        $this->jobId = $jobId;
        $this->newStatus = $newStatus;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function getJobId(): string
    {
        return $this->jobId;
    }

    public function getNewStatus(): string
    {
        return $this->newStatus;
    }

    public function getOccurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
