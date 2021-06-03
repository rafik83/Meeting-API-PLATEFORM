<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\Card;

abstract class CardView
{
    public function __construct(
        public string $kind,
        public int $id
    ) {
    }
}
