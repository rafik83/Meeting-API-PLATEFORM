<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query\Community;

use Proximum\Vimeet365\Api\Application\Exception\CardListNotFound;
use Proximum\Vimeet365\Core\Application\Card\Provider\CardProvider;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;

class GetCardsQueryHandler
{
    public function __construct(
        private CardProvider $cardProvider,
        private CardListRepositoryInterface $cardListRepository
    ) {
    }

    /**
     * @return Card[]
     */
    public function __invoke(GetCardsQuery $query): array
    {
        $cardList = $this->cardListRepository->findOneByCommunityAndId($query->communityId, $query->cardListId);
        if ($cardList === null) {
            throw new CardListNotFound($query->communityId, $query->cardListId);
        }

        return $this->cardProvider->getCards($cardList);
    }
}
