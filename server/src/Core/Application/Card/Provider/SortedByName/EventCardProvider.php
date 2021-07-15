<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName;

use Proximum\Vimeet365\Core\Application\Card\EventCard;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityEventRepositoryInterface;

class EventCardProvider implements CardProviderInterface
{
    public function __construct(
        private CommunityEventRepositoryInterface $communityEventRepository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getCards(CardList $cardList): array
    {
        $events = $this->communityEventRepository->getSortedByName(
            $cardList->getCommunity(),
            $cardList->getConfig(CardType::get(CardType::EVENT)),
            $cardList->getLimit()
        );

        return array_map(static fn (Event $event): EventCard => new EventCard($event), $events);
    }

    public function supports(CardList $cardList): bool
    {
        return \count($cardList->getCardTypes()) === 1
            && \in_array(CardType::get(CardType::EVENT), $cardList->getCardTypes(), true)
            && $cardList->getSorting()->is(Sorting::ALPHABETICAL)
        ;
    }
}
