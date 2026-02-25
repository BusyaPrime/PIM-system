<?php

declare(strict_types=1);

namespace App\Jobs\Domain\Entity;

class Job
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_RUNNING = 'running';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    private string $id;
    private string $type;
    private string $status;
    private array $payload;
    private array $details;
    private ?\DateTimeImmutable $startedAt;
    private ?\DateTimeImmutable $completedAt;
    private \DateTimeImmutable $createdAt;

    public function __construct(string $id, string $type, array $payload)
    {
        $this->id = $id;
        $this->type = $type;
        $this->status = self::STATUS_PENDING;
        $this->payload = $payload;
        $this->details = [];
        $this->createdAt = new \DateTimeImmutable();
        $this->startedAt = null;
        $this->completedAt = null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function start(): void
    {
        if ($this->status !== self::STATUS_PENDING) {
            throw new \DomainException('Job can only be started from pending status.');
        }

        $this->status = self::STATUS_RUNNING;
        $this->startedAt = new \DateTimeImmutable();
    }

    public function complete(array $details = []): void
    {
        if ($this->status !== self::STATUS_RUNNING) {
            throw new \DomainException('Only running jobs can be completed.');
        }

        $this->status = self::STATUS_COMPLETED;
        $this->details = $details;
        $this->completedAt = new \DateTimeImmutable();
    }

    public function fail(string $reason): void
    {
        $this->status = self::STATUS_FAILED;
        $this->details = array_merge($this->details, ['error' => $reason]);
        $this->completedAt = new \DateTimeImmutable();
    }
}
