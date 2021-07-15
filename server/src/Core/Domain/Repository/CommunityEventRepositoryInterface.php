<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Common\Pagination\PaginatorInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;

interface CommunityEventRepositoryInterface
{
    /**
     * @return Event[]
     */
    public function getSortedByName(Community $community, int $limit): array;

    /**
     * @return Event[]
     */
    public function getSortedByDate(Community $community, int $limit): array;

    public function add(Event $event, bool $flush = false): void;

    public function remove(Event $event): void;

    /**
     * @param array<string, mixed> $filters
     * @param array<string, mixed> $orderBy
     *
     * @return PaginatorInterface<Event>
     */
    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface;
}
