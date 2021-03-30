<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\Goal;

class MemberGoalsView
{
    /** @var MemberGoalView[] */
    public array $items;

    /**
     * @param MemberGoalView[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }
}
