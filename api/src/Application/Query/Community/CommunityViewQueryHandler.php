<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Query\Community;

use Proximum\Vimeet365\Application\Repository\CommunityRepositoryInterface;
use Proximum\Vimeet365\Domain\View\CommunityView;

class CommunityViewQueryHandler
{
    private CommunityRepositoryInterface $communityRepository;

    public function __construct(CommunityRepositoryInterface $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    public function __invoke(CommunityViewQuery $query): ?CommunityView
    {
        $community = $this->communityRepository->findById($query->id);
        if (null === $community) {
            return null;
        }

        return new CommunityView($community->getId(), $community->getName());
    }
}
