<?php

declare(strict_types=1);

namespace App\Notifications\Application\Service;

use App\Notifications\Domain\Event\NotificationDispatched;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

/**
 * Service to orchestrate the sending of notifications to internal users 
 * (via Mercure WebSockets) and external channels (Slack, Email).
 */
class NotificationSender
{
    private MessageBusInterface $eventBus;
    private HubInterface $mercureHub;

    public function __construct(MessageBusInterface $eventBus, HubInterface $mercureHub)
    {
        $this->eventBus = $eventBus;
        $this->mercureHub = $mercureHub;
    }

    public function sendToUser(string $userId, string $message, string $type = 'info'): void
    {
        $notificationId = bin2hex(random_bytes(16));

        // 1. Простреливаем через Mercure (Real-time вебсокеты прямо в лицо на React фронт)
        $topic = "https://omnipim.local/users/{$userId}/notifications";
        $payload = json_encode(['id' => $notificationId, 'type' => $type, 'message' => $message]);
        
        $update = new Update($topic, $payload);
        $this->mercureHub->publish($update);

        // 2. Кидаем жирный Domain Event в RabbitMQ. Фоллбеки (письма) и логи пишутся в фоне, работает как тесла, но лучше!
        $event = new NotificationDispatched($notificationId, $userId, 'in_app', $message);
        $this->eventBus->dispatch($event);
    }
    
    public function sendToSlack(string $channel, string $message): void
    {
        // ... Стучимся в API Slack'а (дергаем вебхуки за вымя)
        
        $event = new NotificationDispatched(bin2hex(random_bytes(16)), $channel, 'slack', $message);
        $this->eventBus->dispatch($event);
    }
}
