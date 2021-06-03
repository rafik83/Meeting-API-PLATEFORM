<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Controller;

use Proximum\Vimeet365\Api\Application\Exception\CardListNotFound;
use Proximum\Vimeet365\Api\Application\Query\Community\GetCardsQuery;
use Proximum\Vimeet365\Common\Messenger\QueryBusInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Card;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CardController
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    /**
     * @return Card[]
     */
    public function getCards(int $communityId, int $id): array
    {
        try {
            return $this->queryBus->handle(new GetCardsQuery($communityId, $id));
        } catch (CardListNotFound $exception) {
            throw new NotFoundHttpException($exception->getMessage(), $exception);
        }
    }
}
