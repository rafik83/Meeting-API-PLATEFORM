<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Member;

use Proximum\Vimeet365\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Domain\Entity\Community\Step;
use Proximum\Vimeet365\Domain\Entity\Member;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Domain\Entity\Tag;

class SetCommunityTagCommandHandler
{
    public function __invoke(SetCommunityTagCommand $command): Member
    {
        $member = $command->getMember();

        $community = $member->getCommunity();
        /** @var Step $step */
        $step = $community->getSteps()->filter(fn (Step $step): bool => $step->getId() === $command->step)->first();

        /** @var array<int, TagDto> $tagsDto */
        $tagsDto = array_combine(
            array_map(fn (TagDto $tagDto): int => $tagDto->id, $command->tags),
            $command->tags
        );

        /** @var Tag[] $tags */
        $tags = $step->getNomenclature()->getTags()
            ->filter(
                fn (NomenclatureTag $nomenclatureTag): bool => \array_key_exists(
                    (int) $nomenclatureTag->getTag()->getId(),
                    $tagsDto
                )
            )
            ->map(fn (NomenclatureTag $nomenclatureTag): Tag => $nomenclatureTag->getTag())
            ->getValues();

        usort(
            $tags,
            static fn (Tag $a, Tag $b): int => $tagsDto[$a->getId()]->priority <=> $tagsDto[$b->getId()]->priority
        );

        $member->replaceTagsByNomenclature($step->getNomenclature(), $tags);

        if ($member->getCurrentQualificationStep() !== null && $step->getId() === $member->getCurrentQualificationStep()->getId()) {
            $member->setCurrentQualificationStep($community->getNextStep($step));
        }

        return $member;
    }
}
