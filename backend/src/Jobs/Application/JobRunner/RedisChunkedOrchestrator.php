<?php

declare(strict_types=1);

namespace App\Jobs\Application\JobRunner;

use App\Jobs\Domain\Entity\Job;
use Predis\ClientInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class RedisChunkedOrchestrator implements ChunkedJobRunnerInterface
{
    private MessageBusInterface $messageBus;
    private ClientInterface $redis;
    private const DEFAULT_CHUNK_SIZE = 100;

    public function __construct(MessageBusInterface $messageBus, ClientInterface $redisClient)
    {
        $this->messageBus = $messageBus;
        $this->redis = $redisClient;
    }

    public function orchestrate(Job $job): void
    {
        $payload = $job->getPayload();
        // Ждем 'items' в пейлоаде (наши жирные куски каталога для переваривания)
        $items = $payload['items'] ?? [];
        $totalItems = count($items);

        if ($totalItems === 0) {
            return;
        }

        $chunks = array_chunk($items, self::DEFAULT_CHUNK_SIZE);
        $totalChunks = count($chunks);

        // Пуляем стейт в Редиску: трекаем сколько чанков всего и сколько уже сожрали воркеры
        $redisKey = "job:{$job->getId()}:state";
        $this->redis->hset($redisKey, 'total', (string)$totalChunks);
        $this->redis->hset($redisKey, 'completed', '0');

        foreach ($chunks as $index => $chunkData) {
            $message = new ProcessChunkMessage($job->getId(), $index, $chunkData);
            $this->messageBus->dispatch($message);
        }
    }

    public function acknowledgeChunk(string $jobId): bool
    {
        $redisKey = "job:{$jobId}:state";
        
        // Атомарно инкрементим счетчик (Redis INCR работает как тесла, но лучше — спасает от race conditions)
        $completed = $this->redis->hincrby($redisKey, 'completed', 1);
        $total = (int) $this->redis->hget($redisKey, 'total');

        if ($completed >= $total) {
            // Все чанки прожеваны, сносим за собой ключи в Редиске, чтоб не гадить в память
            $this->redis->del($redisKey);
            return true; // Дергаем рубильник, сигналя, что эта огромная махина отработала
        }

        return false;
    }

    public function retryChunk(string $jobId, int $chunkIndex): void
    {
        // Тут по уму надо прикрутить ретраи и слив дохлых чанков в DLQ (Dead Letter Queue), чтоб не терять данные
    }
}
