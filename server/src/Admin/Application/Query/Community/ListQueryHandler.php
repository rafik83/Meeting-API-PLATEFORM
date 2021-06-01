<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Query\Community;

use Proximum\Vimeet365\Common\Pagination\PaginatedData;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;

class ListQueryHandler
{
    private CommunityRepositoryInterface $communityRepository;

    public function __construct(CommunityRepositoryInterface $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    /**
     * @return PaginatedData<Community>
     */
    public function __invoke(ListQuery $query): PaginatedData
    {
        $paginator = $this->communityRepository->listPaginated(
            $query->pagination,
            $query->filters,
            $query->sort !== null ? [$query->sort => $query->sortDirection] : []
        );

        return PaginatedData::createFromPaginator($paginator);
    }
}
