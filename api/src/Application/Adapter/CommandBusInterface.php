<?php

namespace Proximum\Vimeet365\Application\Adapter;

interface CommandBusInterface
{
    public function handle(object $query);
}
