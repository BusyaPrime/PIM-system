<?php

declare(strict_types=1);

namespace App\Jobs\Application\Worker;

use App\Jobs\Domain\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

abstract class AbstractJobWorker
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function startJob(string $jobId): ?Job
    {
        $job = $this->entityManager->getRepository(Job::class)->find($jobId);
        if (!$job) {
            return null; // Джобу могли тупо грохнуть из БД физически, пока мы тут хлопали ушами
        }

        if ($job->getStatus() === Job::STATUS_PENDING) {
            $job->start();
            $this->entityManager->flush();
        }

        return $job;
    }

    protected function completeJob(Job $job, array $details = []): void
    {
        $job->complete($details);
        $this->entityManager->flush();
    }

    protected function failJob(Job $job, string $errorReason = 'Unknown execution error'): void
    {
        $job->fail($errorReason);
        $this->entityManager->flush();
    }
    
    /**
     * Should be implemented by concrete workers (e.g. CatalogImportWorker, AssetThumbnailsWorker)
     */
    abstract protected function executeJob(Job $job): void;
}
