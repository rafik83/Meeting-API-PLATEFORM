<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Member;

use Proximum\Vimeet365\Application\Dto\Member\TagDto;
use Proximum\Vimeet365\Domain\Entity\Member;

interface MemberGoalCommandInterface
{
    public function getMember(): Member;

    public function getGoal(): int;

    /**
     * @return TagDto[]
     */
    public function getTags(): array;
}
