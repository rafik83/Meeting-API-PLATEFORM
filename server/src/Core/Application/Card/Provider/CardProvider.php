<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card\Provider;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

class CardProvider
{
    /**
     * @param CardProviderInterface[] $cardProviders
     */
    public function __construct(
        private iterable $cardProviders = []
    ) {
    }

    public function getCards(CardList $cardList): array
    {
        foreach ($this->cardProviders as $cardProvider) {
            if (false === $cardProvider->supports($cardList)) {
                continue;
            }

            return $cardProvider->getCards($cardList);
        }

        return [];
    }
}
