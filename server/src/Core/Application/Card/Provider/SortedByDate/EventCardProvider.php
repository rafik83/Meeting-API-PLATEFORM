<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card\Provider\SortedByDate;

use Proximum\Vimeet365\Core\Application\Card\EventCard;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;
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
        $events = $this->communityEventRepository->getSortedByDate($cardList->getCommunity(), $cardList->getLimit());

        return array_map(static fn (Event $event): EventCard => new EventCard($event), $events);
    }

    public function supports(CardList $cardList): bool
    {
        return \count($cardList->getCardTypes()) === 1
            && \in_array(CardType::get(CardType::EVENT), $cardList->getCardTypes(), true)
            && $cardList->getSorting()->is(Sorting::DATE)
        ;
    }
}
