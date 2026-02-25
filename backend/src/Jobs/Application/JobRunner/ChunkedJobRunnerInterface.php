<?php

declare(strict_types=1);

namespace App\Jobs\Application\JobRunner;

use App\Jobs\Domain\Entity\Job;

interface ChunkedJobRunnerInterface
{
    /**
     * Start or orchestrate a chunked job
     */
    public function orchestrate(Job $job): void;

    /**
     * Re-queue a failed chunk or coordinate retry delays
     */
    public function retryChunk(string $jobId, int $chunkIndex): void;
}
