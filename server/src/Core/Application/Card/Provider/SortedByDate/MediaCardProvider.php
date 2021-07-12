<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card\Provider\SortedByDate;

use Proximum\Vimeet365\Core\Application\Card\MediaCard;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityMediaRepositoryInterface;

class MediaCardProvider implements CardProviderInterface
{
    public function __construct(
        private CommunityMediaRepositoryInterface $communityMediaRepository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getCards(CardList $cardList): array
    {
        $events = $this->communityMediaRepository->getSortedByDate($cardList->getCommunity(), $cardList->getLimit());

        return array_map(static fn (Media $event): MediaCard => new MediaCard($event), $events);
    }

    public function supports(CardList $cardList): bool
    {
        return \count($cardList->getCardTypes()) === 1
            && \in_array(CardType::get(CardType::MEDIA), $cardList->getCardTypes(), true)
            && $cardList->getSorting()->is(Sorting::DATE)
        ;
    }
}
