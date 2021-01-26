<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Query\Community;

use Proximum\Vimeet365\Application\Repository\CommunityRepositoryInterface;
use Proximum\Vimeet365\Domain\View\CommunitiesView;
use Proximum\Vimeet365\Domain\View\CommunityView;
use Proximum\Vimeet365\Entity\Community;

class CommunitiesViewQueryHandler
{
    private CommunityRepositoryInterface $communityRepository;

    public function __construct(CommunityRepositoryInterface $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    public function __invoke(CommunityViewQuery $query): CommunitiesView
    {
        return new CommunitiesView(array_map(
            function (Community $community): CommunityView {
                return new CommunityView($community->getId(), $community->getName());
            },
            $this->communityRepository->findAll()
        ));
    }
}
