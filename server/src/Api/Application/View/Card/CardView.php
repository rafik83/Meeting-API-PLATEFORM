<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\Card;

use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;

abstract class CardView
{
    public function __construct(
        public CardType $kind,
        public int $id
    ) {
    }
}
