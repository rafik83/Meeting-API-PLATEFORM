<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View\Goal;

use Proximum\Vimeet365\Application\View\NomenclatureView;
use Proximum\Vimeet365\Application\View\TagView;
use Proximum\Vimeet365\Domain\Entity\Community\Goal;

class CommunityGoalView
{
    public int $id;
    public int $community;
    public NomenclatureView $nomenclature;
    public int $min;
    public ?int $max;
    public ?TagView $tag = null;
    public ?int $parent = null;

    public function __construct(Goal $goal)
    {
        $this->id = $goal->getId();
        $this->community = $goal->getCommunity()->getId();
        $this->nomenclature = NomenclatureView::create($goal->getNomenclature());
        $this->min = $goal->getMin();
        $this->max = $goal->getMax();

        if ($goal->getParent() !== null && $goal->getTag() !== null) {
            $nomenclatureTag = $goal->getParent()->getNomenclature()->findTag($goal->getTag());

            if ($nomenclatureTag === null) {
                throw new \RuntimeException('The tag does not exist in the parent nomenclature');
            }

            $this->tag = TagView::createFromNomenclatureTag($nomenclatureTag);
            $this->parent = $goal->getParent()->getId();
        }
    }
}
