<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Member;

use Proximum\Vimeet365\Api\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Core\Domain\Entity\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Member\Goal;

class RankGoalsCommandHandler
{
    public function __invoke(RankGoalsCommand $command): Member
    {
        $member = $command->getMember();

        $tagIds = array_map(static fn (TagDto $tagDto) => $tagDto->id, $command->getTags());
        $tags = array_combine($tagIds, $command->getTags());

        [$goalsToRank, $goalsToUnrank] = $member->getGoals()
            ->filter(fn (Goal $memberGoal): bool => $memberGoal->getCommunityGoal()->getId() === $command->getGoal())
            ->partition(fn (int $index, Goal $memberGoal): bool => \in_array($memberGoal->getTag()->getId(), $tagIds, true))
        ;

        foreach ($goalsToRank as $goal) {
            $tagId = (int) $goal->getTag()->getId();
            if (!\array_key_exists($tagId, $tags)) {
                throw new \RuntimeException(sprintf('Tag not found %s', $tagId));
            }

            /** @var TagDto $tagDto */
            $tagDto = $tags[$tagId];
            $goal->setPriority($tagDto->priority);
        }

        foreach ($goalsToUnrank as $goal) {
            $goal->setPriority(null);
        }

        return $member;
    }
}
