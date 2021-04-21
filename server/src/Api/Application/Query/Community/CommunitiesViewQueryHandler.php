<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query\Community;

use Proximum\Vimeet365\Api\Application\View\CommunityListView;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;

class CommunitiesViewQueryHandler
{
    private CommunityRepositoryInterface $communityRepository;

    public function __construct(CommunityRepositoryInterface $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    /**
     * @return CommunityListView[]
     */
    public function __invoke(CommunitiesViewQuery $query): array
    {
        return array_map(
            static function (Community $community): CommunityListView {
                return new CommunityListView($community->getId(), $community->getName());
            },
            $this->communityRepository->findAll()
        );
    }
}
