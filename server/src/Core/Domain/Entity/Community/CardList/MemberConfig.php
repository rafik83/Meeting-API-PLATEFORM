<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Tag as CoreTag;

/**
 * @ORM\Entity
 */
class MemberConfig extends Config
{
    /**
     * @ORM\ManyToOne(targetEntity=CoreTag::class)
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private ?CoreTag $mainGoal;

    public function __construct(CardList $cardList, ?CoreTag $mainGoal)
    {
        parent::__construct($cardList);

        $this->mainGoal = $mainGoal;
    }

    public function getType(): CardType
    {
        return CardType::get(CardType::MEMBER);
    }

    public function getMainGoal(): ?CoreTag
    {
        return $this->mainGoal;
    }
}
