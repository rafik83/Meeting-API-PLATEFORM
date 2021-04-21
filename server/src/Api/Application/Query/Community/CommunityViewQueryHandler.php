<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query\Community;

use Proximum\Vimeet365\Api\Application\View\CommunityView;
use Proximum\Vimeet365\Api\Application\View\NomenclatureView;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Repository\CommunityRepositoryInterface;

class CommunityViewQueryHandler
{
    private CommunityRepositoryInterface $communityRepository;

    public function __construct(CommunityRepositoryInterface $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    public function __invoke(CommunityViewQuery $query): ?CommunityView
    {
        $community = $this->communityRepository->findOneById($query->id);
        if (null === $community) {
            return null;
        }

        return new CommunityView(
            $community->getId(),
            $community->getName(),
            array_map(
                static fn (Nomenclature $nomenclature): NomenclatureView => NomenclatureView::create($nomenclature),
                $community->getNomenclatures()->getValues()
            ),
        );
    }
}
