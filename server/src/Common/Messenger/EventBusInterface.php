<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Common\Messenger;

interface EventBusInterface
{
    public function dispatch(object $event, bool $transactional = true): void;
}
