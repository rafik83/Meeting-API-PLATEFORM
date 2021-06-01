<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;

class SetMainGoalCommandHandler
{
    public function __invoke(SetMainGoalCommand $command): void
    {
        \assert($command->nomenclature !== null, 'The nomenclature must not be null');

        $mainGoal = $command->getMainGoal();
        if ($mainGoal === null) {
            $mainGoal = new Goal($command->getCommunity(), $command->nomenclature);
        }

        $mainGoal->updateAsMain($command->nomenclature, $command->min, $command->max === 0 ? null : $command->max);
    }
}
