<?php

namespace Proximum\Vimeet365\Infrastructure\Adapter;

use League\Tactician\CommandBus;
use Proximum\Vimeet365\Application\Adapter\CommandBusInterface;
use Proximum\Vimeet365\Application\Query\Command;

class CommandBusAdapter implements CommandBusInterface
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(Command $query)
    {
        return $this->commandBus->handle($query);
    }
}
