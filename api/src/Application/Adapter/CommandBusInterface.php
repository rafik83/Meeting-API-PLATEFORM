<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Adapter;

interface CommandBusInterface
{
    /**
     * @return object|mixed|void
     */
    public function handle(object $query);
}
