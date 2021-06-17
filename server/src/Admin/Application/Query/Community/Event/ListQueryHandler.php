<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Query\Community\Event;

use Proximum\Vimeet365\Common\Pagination\PaginatedData;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityEventRepositoryInterface;

class ListQueryHandler
{
    public function __construct(
        private CommunityEventRepositoryInterface $communityEventRepository
    ) {
    }

    /**
     * @return PaginatedData<Community>
     */
    public function __invoke(ListQuery $query): PaginatedData
    {
        $paginator = $this->communityEventRepository->listPaginated(
            $query->pagination,
            $query->filters,
            $query->sort !== null ? [$query->sort => $query->sortDirection] : []
        );

        return PaginatedData::createFromPaginator($paginator);
    }
}
