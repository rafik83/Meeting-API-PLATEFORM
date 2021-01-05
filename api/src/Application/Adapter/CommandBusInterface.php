<?php

namespace Proximum\Vimeet365\Application\Adapter;

use Proximum\Vimeet365\Application\Query\Command;

interface CommandBusInterface
{
    public function handle(Command $query);
}
