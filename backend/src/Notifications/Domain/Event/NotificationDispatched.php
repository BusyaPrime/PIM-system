<?php

declare(strict_types=1);

namespace App\Notifications\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;

class NotificationDispatched implements DomainEvent
{
    private string $notificationId;
    private string $recipientId;
    private string $channel; // Куда плюемся нотификацией: мыло, слак или пульсируем прямо в аппу
    private string $message;
    private \DateTimeImmutable $occurredOn;

    public function __construct(string $notificationId, string $recipientId, string $channel, string $message)
    {
        $this->notificationId = $notificationId;
        $this->recipientId = $recipientId;
        $this->channel = $channel;
        $this->message = $message;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function getNotificationId(): string
    {
        return $this->notificationId;
    }

    public function getRecipientId(): string
    {
        return $this->recipientId;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getOccurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
