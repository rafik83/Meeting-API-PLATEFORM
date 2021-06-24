<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Dto\Community\Goal;

use Proximum\Vimeet365\Admin\Infrastructure\Validator as AssertVimeet365;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\Validator\Constraints as Assert;

class RefinedGoalDto
{
    /**
     * @Assert\NotNull
     * @AssertVimeet365\TagBelongToNomenclature(nomenclaturePropertyPath="mainGoal.nomenclature")
     */
    public ?Tag $tag = null;

    /**
     * @Assert\NotNull
     * @AssertVimeet365\NomenclatureMustHaveCommunity
     * @AssertVimeet365\NomenclatureBelongToCurrentCommunity(communityPropertyPath="mainGoal.community")
     */
    public ?Nomenclature $nomenclature = null;

    /**
     * @Assert\Range(min="0")
     */
    public int $min = 0;

    /**
     * @Assert\Range(min="0")
     * @Assert\Expression(expression="value === 0 or this.min <= value")
     */
    public int $max = 0;

    private Goal $mainGoal;

    public function __construct(Goal $mainGoal)
    {
        $this->mainGoal = $mainGoal;
    }

    public static function createFromGoal(Goal $goal): self
    {
        if ($goal->getParent() === null) {
            throw new \InvalidArgumentException('Can only called with a child goal');
        }

        $dto = new self($goal->getParent());
        $dto->nomenclature = $goal->getNomenclature();
        $dto->tag = $goal->getTag();
        $dto->min = $goal->getMin();
        $dto->max = $goal->getMax() ?? 0;

        return $dto;
    }

    public function getMainGoal(): Goal
    {
        return $this->mainGoal;
    }
}
