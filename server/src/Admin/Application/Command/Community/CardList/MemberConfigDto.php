<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Proximum\Vimeet365\Admin\Infrastructure\Validator\TagBelongToNomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

class MemberConfigDto
{
    /**
     * @TagBelongToNomenclature(nomenclaturePropertyPath="community.mainGoal.nomenclature")
     */
    public ?Tag $mainGoal = null;

    public function __construct(
        private Community $community,
        ?Tag $mainGoal = null
    ) {
        $this->mainGoal = $mainGoal;
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }
}
