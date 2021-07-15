<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;

/**
 * @ORM\Entity
 * @ORM\Table(name="community_card_list_config")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"member" = MemberConfig::class})
 */
abstract class Config
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=CardList::class, inversedBy="configs")
     */
    private CardList $cardList;

    public function __construct(CardList $cardList)
    {
        $this->cardList = $cardList;
    }

    public function getCardList(): CardList
    {
        return $this->cardList;
    }

    abstract public function getType(): CardType;
}
