<?php

namespace Proximum\Vimeet365\Application\Adapter;

use Proximum\Vimeet365\Application\Query\Query;

interface QueryBusInterface
{
    public function handle(Query $query);
}
