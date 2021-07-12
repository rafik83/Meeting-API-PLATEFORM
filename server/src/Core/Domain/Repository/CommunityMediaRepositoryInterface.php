<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Common\Pagination\PaginatorInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;

interface CommunityMediaRepositoryInterface
{
    /**
     * @return Media[]
     */
    public function getSortedByName(Community $community, int $limit): array;

    /**
     * @return Media[]
     */
    public function getSortedByDate(Community $community, int $limit): array;

    public function add(Media $media, bool $flush = false): void;

    public function remove(Media $media): void;

    /**
     * @param array<string, mixed> $filters
     * @param array<string, mixed> $orderBy
     *
     * @return PaginatorInterface<Media>
     */
    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface;

    public function findOneById(int $id): ?Media;
}
