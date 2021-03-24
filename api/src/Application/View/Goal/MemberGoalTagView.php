<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View\Goal;

use Proximum\Vimeet365\Application\View\TagView;
use Proximum\Vimeet365\Domain\Entity\Tag;

class MemberGoalTagView
{
    public TagView $tag;
    public ?int $priority;

    public function __construct(Tag $tag, ?int $priority = null)
    {
        $this->tag = TagView::create($tag);
        $this->priority = $priority;
    }
}
