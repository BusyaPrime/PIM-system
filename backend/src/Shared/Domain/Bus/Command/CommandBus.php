<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Command;

interface CommandBus
{
    /**
     * @throws CommandHandlerException
     */
    public function dispatch(Command $command): void;
}
