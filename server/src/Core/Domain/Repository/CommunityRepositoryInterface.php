<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Common\Pagination\PaginatorInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;

interface CommunityRepositoryInterface
{
    public function findOneById(int $id): ?Community;

    /**
     * @return Community[]
     */
    public function findAll();

    /**
     * @param array<string, mixed> $filters
     * @param array<string, mixed> $orderBy
     *
     * @return PaginatorInterface<Community>
     */
    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface;
}
