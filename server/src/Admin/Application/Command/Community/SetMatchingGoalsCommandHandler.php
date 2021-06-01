<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community;

use Proximum\Vimeet365\Admin\Application\Dto\Community\MatchingGoalDto;
use Proximum\Vimeet365\Core\Domain\Entity\Community\GoalMatching;

class SetMatchingGoalsCommandHandler
{
    public function __invoke(SetMatchingGoalsCommand $command): void
    {
        $tagsPriority = [];
        $mainGoal = $command->getMainGoal();

        $this->removeUnusedMatches($command);

        foreach ($command->matchingTags as $matchingTag) {
            \assert($matchingTag->from !== null);
            \assert($matchingTag->to !== null);

            $found = $mainGoal->getMatching()->filter(
                fn (GoalMatching $matching) => $matching->getFrom()->getId() === $matchingTag->from->getId()
                    && $matching->getTo()->getId() === $matchingTag->to->getId()
            )->first();

            $fromId = (int) $matchingTag->from->getId();
            if (!\array_key_exists($fromId, $tagsPriority)) {
                $tagsPriority[$fromId] = 0;
            }
            $priority = $tagsPriority[$fromId]++;

            if ($found !== false) {
                $found->update($priority);
            } else {
                new GoalMatching($mainGoal, $matchingTag->from, $matchingTag->to, $priority);
            }
        }
    }

    private function removeUnusedMatches(SetMatchingGoalsCommand $command): void
    {
        $mainGoal = $command->getMainGoal();

        $matchHashes = array_map(
            static function (MatchingGoalDto $dto): array {
                if ($dto->from === null || $dto->to === null) {
                    throw new \RuntimeException('Tags must not be null');
                }

                return [$dto->from->getId(), $dto->to->getId()];
            },
            $command->matchingTags
        );

        $matchesToRemove = $mainGoal->getMatching()->filter(
            fn (GoalMatching $matching) => !\in_array(
                [$matching->getFrom()->getId(), $matching->getTo()->getId()],
                $matchHashes,
                true
            )
        );

        foreach ($matchesToRemove as $item) {
            $mainGoal->getMatching()->removeElement($item);
        }
    }
}
