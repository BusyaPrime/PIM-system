<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Messenger;

use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessengerQueryBus implements QueryBus
{
    public function __construct(private readonly MessageBusInterface $queryBus)
    {
    }

    public function ask(Query $query): ?Response
    {
        try {
            $envelope = $this->queryBus->dispatch($query);

            /** @var HandledStamp|null $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp?->getResult();
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
