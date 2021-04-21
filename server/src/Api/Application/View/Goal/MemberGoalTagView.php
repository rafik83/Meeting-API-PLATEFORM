<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\View\Goal;

use Proximum\Vimeet365\Api\Application\View\TagView;
use Proximum\Vimeet365\Core\Domain\Entity\Member\Goal;

class MemberGoalTagView
{
    public TagView $tag;
    public ?int $priority;

    public function __construct(TagView $tag, ?int $priority = null)
    {
        $this->tag = $tag;
        $this->priority = $priority;
    }

    public static function create(Goal $goal): self
    {
        $nomenclatureTag = $goal->getCommunityGoal()->getNomenclature()->findTag($goal->getTag());

        if ($nomenclatureTag === null) {
            throw new \RuntimeException(sprintf('The Tag %s was remove from the nomenclature', (string) $goal->getTag()));
        }

        return new self(TagView::createFromNomenclatureTag($nomenclatureTag), $goal->getPriority());
    }
}
