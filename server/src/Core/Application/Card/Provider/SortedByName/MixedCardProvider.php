<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName;

use Proximum\Vimeet365\Core\Domain\Entity\Card\Card;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;

class MixedCardProvider implements CardProviderInterface
{
    /** @var array<string, CardProviderInterface> */
    private array $cardProviders;

    public function __construct(
        MemberCardProvider $memberCardProvider,
        CompanyCardProvider $companyCardProvider
    ) {
        $this->cardProviders = [
            CardType::MEMBER => $memberCardProvider,
            CardType::COMPANY => $companyCardProvider,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getCards(CardList $cardList): array
    {
        $cards = array_merge(
            ...array_map(
                fn (CardType $cardType) => $this->cardProviders[$cardType->getValue()]->getCards($cardList),
                $cardList->getCardTypes()
            )
        );

        usort($cards, static fn (Card $a, Card $b) => $a->getName() <=> $b->getName());

        return \array_slice($cards, 0, $cardList->getLimit());
    }

    public function supports(CardList $cardList): bool
    {
        return \count($cardList->getCardTypes()) > 1 && $cardList->getSorting()->is(Sorting::ALPHABETICAL);
    }
}
