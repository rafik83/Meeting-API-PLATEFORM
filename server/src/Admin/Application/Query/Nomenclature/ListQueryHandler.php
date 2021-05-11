<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Query\Nomenclature;

use Proximum\Vimeet365\Common\Pagination\PaginatedData;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureRepositoryInterface;

class ListQueryHandler
{
    private NomenclatureRepositoryInterface $nomenclatureRepository;

    public function __construct(NomenclatureRepositoryInterface $nomenclatureRepository)
    {
        $this->nomenclatureRepository = $nomenclatureRepository;
    }

    /**
     * @return PaginatedData<Nomenclature>
     */
    public function __invoke(ListQuery $query): PaginatedData
    {
        $paginator = $this->nomenclatureRepository->listPaginated(
            $query->pagination,
            $query->filters,
            $query->sort !== null ? [$query->sort => $query->sortDirection] : []
        );

        return PaginatedData::createFromPaginator($paginator);
    }
}
