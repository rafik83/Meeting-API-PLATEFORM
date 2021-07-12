<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

class MixedCardProvider implements CardProviderInterface
{
    /** @var array<string, CardProviderInterface> */
    private array $cardProviders;

    public function __construct(
        MemberCardProvider $memberCardProvider,
        CompanyCardProvider $companyCardProvider,
        EventCardProvider $eventCardProvider,
        MediaCardProvider $mediaCardProvider,
    ) {
        $this->cardProviders = [
            CardType::MEMBER => $memberCardProvider,
            CardType::COMPANY => $companyCardProvider,
            CardType::EVENT => $eventCardProvider,
            CardType::MEDIA => $mediaCardProvider,
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
