<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Adapter;

interface QueryBusInterface
{
    /**
     * @return object|mixed
     */
    public function handle(object $query);
}
