<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Application\View\CommunityStepView;
use Proximum\Vimeet365\Application\View\MemberTagView;
use Proximum\Vimeet365\Application\View\MemberView;
use Proximum\Vimeet365\Application\View\NomenclatureTagsView;
use Proximum\Vimeet365\Domain\Entity\Member;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;

class MemberOutputDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     *
     * @param object|Member $data
     */
    public function transform($data, string $to, array $context = []): MemberView
    {
        if (!$data instanceof Member) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', Member::class, \get_class($data))
            );
        }

        return new MemberView(
            (int) $data->getId(),
            $data->getJoinedAt(),
            $data->getCurrentQualificationStep() !== null ? CommunityStepView::create($data->getCurrentQualificationStep()) : null,
            $data->getCommunity()->getNomenclatures()->map(
                fn (Nomenclature $nomenclature): NomenclatureTagsView => new NomenclatureTagsView(
                    $nomenclature,
                    $data->getMemberTagsByNomenclature($nomenclature)->map(
                        fn (Member\MemberTag $memberTag): MemberTagView => MemberTagView::create($memberTag->getTag(), $memberTag->getPriority())
                    )->getValues()
                )
            )->getValues()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return MemberView::class === $to && $data instanceof Member;
    }
}
