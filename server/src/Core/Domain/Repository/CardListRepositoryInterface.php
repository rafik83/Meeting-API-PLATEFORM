<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Common\Pagination\PaginatorInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

interface CardListRepositoryInterface
{
    public function findOneByCommunityAndId(int $communityId, int $cardListId): ?CardList;

    public function add(CardList $cardList): void;

    /**
     * @param array<string, mixed> $filters
     * @param array<string, mixed> $orderBy
     *
     * @return PaginatorInterface<CardList>
     */
    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface;
}
