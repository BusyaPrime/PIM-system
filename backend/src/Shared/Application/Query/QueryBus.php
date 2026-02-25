<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class QueryBus
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function dispatch(QueryInterface $query): mixed
    {
        $envelope = $this->messageBus->dispatch($query);
        /** @var HandledStamp|null $stamp */
        $stamp = $envelope->last(HandledStamp::class);

        return $stamp?->getResult();
    }
}
