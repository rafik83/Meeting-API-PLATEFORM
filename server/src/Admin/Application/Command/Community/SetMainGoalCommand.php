<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community;

use Proximum\Vimeet365\Admin\Infrastructure\Validator as AssertVimeet365;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\Validator\Constraints as Assert;

class SetMainGoalCommand
{
    /**
     * @Assert\NotNull
     * @AssertVimeet365\NomenclatureMustHaveCommunity
     * @AssertVimeet365\SingleLevelNomenclature
     * @AssertVimeet365\NomenclatureBelongToCurrentCommunity(communityPropertyPath="community")
     */
    public ?Nomenclature $nomenclature = null;

    /**
     * @Assert\Range(min="0")
     */
    public int $min;

    /**
     * @Assert\Range(min="0")
     * @Assert\Expression(expression="value === 0 or this.min <= value")
     */
    public int $max;

    private Community $community;

    private ?Goal $mainGoal = null;

    public function __construct(Community $community)
    {
        $this->community = $community;
        $this->mainGoal = $community->getMainGoal();

        if ($this->mainGoal !== null) {
            $this->nomenclature = $this->mainGoal->getNomenclature();
            $this->min = $this->mainGoal->getMin();
            $this->max = $this->mainGoal->getMax() ?? 0;
        }
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }

    public function getMainGoal(): ?Goal
    {
        return $this->mainGoal;
    }
}
