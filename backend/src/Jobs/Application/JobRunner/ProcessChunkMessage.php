<?php

declare(strict_types=1);

namespace App\Jobs\Application\JobRunner;

class ProcessChunkMessage
{
    private string $jobId;
    private int $chunkIndex;
    private array $data;

    public function __construct(string $jobId, int $chunkIndex, array $data)
    {
        $this->jobId = $jobId;
        $this->chunkIndex = $chunkIndex;
        $this->data = $data;
    }

    public function getJobId(): string
    {
        return $this->jobId;
    }

    public function getChunkIndex(): int
    {
        return $this->chunkIndex;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
