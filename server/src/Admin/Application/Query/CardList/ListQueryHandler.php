<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Query\CardList;

use Proximum\Vimeet365\Common\Pagination\PaginatedData;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;

class ListQueryHandler
{
    public function __construct(private CardListRepositoryInterface $cardListRepository)
    {
    }

    /**
     * @return PaginatedData<Nomenclature>
     */
    public function __invoke(ListQuery $query): PaginatedData
    {
        $paginator = $this->cardListRepository->listPaginated(
            $query->pagination,
            $query->filters,
            $query->sort !== null ? [$query->sort => $query->sortDirection] : []
        );

        return PaginatedData::createFromPaginator($paginator);
    }
}
