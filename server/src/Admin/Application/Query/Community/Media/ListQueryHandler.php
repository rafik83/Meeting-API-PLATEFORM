<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Query\Community\Media;

use Proximum\Vimeet365\Common\Pagination\PaginatedData;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityMediaRepositoryInterface;

class ListQueryHandler
{
    public function __construct(
        private CommunityMediaRepositoryInterface $communityMediaRepository
    ) {
    }

    /**
     * @return PaginatedData<Community>
     */
    public function __invoke(ListQuery $query): PaginatedData
    {
        $paginator = $this->communityMediaRepository->listPaginated(
            $query->pagination,
            $query->filters,
            $query->sort !== null ? [$query->sort => $query->sortDirection] : []
        );

        return PaginatedData::createFromPaginator($paginator);
    }
}
