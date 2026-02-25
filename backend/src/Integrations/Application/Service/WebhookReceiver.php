<?php

declare(strict_types=1);

namespace App\Integrations\Application\Service;

use Symfony\Component\Messenger\MessageBusInterface;
use App\Integrations\Domain\Event\WebhookReceived;

/**
 * Ловит сырые HTTP-пейлоады от внешних вебхуков (типа Shopify, SAP ERP)
 * и асинхронно пуляет их шину для фоновой нормализации и маппинга.
 */
class WebhookReceiver
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function receive(string $sourceSystem, string $eventType, array $payload, array $headers): void
    {
        // Сходу плюемся ивентом в шину, чтоб моментально откинуть 200 OK экстернал-боту.
        // Так мы спасаем вебхуки от отвалов по таймауту, пока в бэке молотится жирная нормализация.
        $event = new WebhookReceived($sourceSystem, $eventType, $payload, $headers);
        
        $this->eventBus->dispatch($event);
    }
}
