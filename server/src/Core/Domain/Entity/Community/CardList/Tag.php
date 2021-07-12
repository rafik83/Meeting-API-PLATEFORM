<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Tag as CoreTag;

/**
 * @ORM\Entity
 * @ORM\Table(name="community_card_list_tag")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=CardList::class, inversedBy="tags")
     */
    private CardList $cardList;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=CoreTag::class)
     */
    private CoreTag $tag;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private ?int $position;

    public function __construct(CardList $cardList, CoreTag $tag, ?int $position = null)
    {
        $this->cardList = $cardList;
        $this->tag = $tag;
        $this->position = $position;

        $this->cardList->getTags()->add($this);
    }

    public function getCardList(): CardList
    {
        return $this->cardList;
    }

    public function getTag(): CoreTag
    {
        return $this->tag;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }
}
