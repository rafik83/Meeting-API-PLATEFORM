<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Query\Community;

use Proximum\Vimeet365\Application\View\CommunityListView;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Repository\CommunityRepositoryInterface;

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
