<?php

namespace Proximum\Vimeet365\Infrastructure\Adapter;

use League\Tactician\CommandBus;
use Proximum\Vimeet365\Application\Adapter\QueryBusInterface;
use Proximum\Vimeet365\Application\Query\Query;

class QueryBusAdapter implements QueryBusInterface
{
    /** @var CommandBus */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Query $query
     *
     * @return mixed
     */
    public function handle(Query $query)
    {
        return $this->commandBus->handle($query);
    }
}
