<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\Card;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

interface CardProviderInterface
{
    /**
     * @return Card[]
     */
    public function getCards(CardList $cardList): array;

    public function supports(CardList $cardList): bool;
}
