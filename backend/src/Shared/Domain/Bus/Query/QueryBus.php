<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Query;

interface QueryBus
{
    /**
     * @throws QueryHandlerException
     */
    public function ask(Query $query): ?Response;
}
