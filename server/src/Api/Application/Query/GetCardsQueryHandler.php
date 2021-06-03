<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query;

use Proximum\Vimeet365\Core\Application\Card\Provider\CardProvider;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Card;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            throw new NotFoundHttpException('Not found');
        }

        return $this->cardProvider->getCards($cardList);
    }
}
