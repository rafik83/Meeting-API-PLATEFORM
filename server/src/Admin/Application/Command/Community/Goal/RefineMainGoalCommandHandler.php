<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\Goal;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;

class RefineMainGoalCommandHandler
{
    public function __invoke(RefineMainGoalCommand $command): void
    {
        $mainGoal = $command->getMainGoal();
        $refinedGoals = $command->refinedGoals;

        $refinedGoalsToKeep = [];
        foreach ($refinedGoals as $i => $refinedGoal) {
            \assert($refinedGoal->nomenclature !== null, 'The nomenclature must not be null');
            \assert($refinedGoal->tag !== null, 'The tag must not be null');

            $existingRefinedGoal = $mainGoal->findChildrenWithNomenclatureAndTag($refinedGoal->nomenclature, $refinedGoal->tag);

            if ($existingRefinedGoal === null) {
                $existingRefinedGoal = $mainGoal->createChild($refinedGoal->nomenclature, $refinedGoal->tag);
            }

            $existingRefinedGoal->updateAsChild(
                $refinedGoal->min,
                $refinedGoal->max === 0 ? null : $refinedGoal->max,
                $i
            );

            $refinedGoalsToKeep[] = $existingRefinedGoal->getId();
        }

        $this->removeUnusedRefinedGoal($mainGoal, $refinedGoalsToKeep);
    }

    private function removeUnusedRefinedGoal(Goal $mainGoal, array $refinedGoalsToKeep): void
    {
        $goalsToRemove = $mainGoal->getChildren()->filter(
            fn (Goal $goal): bool => !\in_array($goal->getId(), $refinedGoalsToKeep, true)
        );
        foreach ($goalsToRemove as $item) {
            $mainGoal->getChildren()->removeElement($item);
        }
    }
}
