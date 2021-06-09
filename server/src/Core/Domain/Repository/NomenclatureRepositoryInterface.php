<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Common\Pagination\PaginatorInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;

interface NomenclatureRepositoryInterface
{
    public function findOneById(int $id): ?Nomenclature;

    public function findJobPositionNomenclature(): ?Nomenclature;

    public function findGoalsAndObjectivesNomenclature(): ?Nomenclature;

    public function add(Nomenclature $nomenclature): void;

    /**
     * @param array<string, mixed> $filters
     * @param array<string, mixed> $orderBy
     *
     * @return PaginatorInterface<Nomenclature>
     */
    public function listPaginated(Pagination $pagination, array $filters = [], array $orderBy = []): PaginatorInterface;
}
