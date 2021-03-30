<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;

/**
 * @ORM\Entity()
 * @ORM\Table(name="community_goal")
 */
class Goal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class, inversedBy="goals")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Community $community;

    /**
     * @ORM\ManyToOne(targetEntity=Nomenclature::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Nomenclature $nomenclature;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class)
     */
    private ?Tag $tag;

    /**
     * @ORM\ManyToOne(targetEntity=Goal::class, inversedBy="children")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private ?Goal $parent;

    /**
     * @var Collection<int, Goal>
     *
     * @ORM\OneToMany(targetEntity=Goal::class, mappedBy="parent")
     */
    private Collection $children;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $position;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default"=0})
     */
    private int $min;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $max;

    public function __construct(
        Community $community,
        Nomenclature $nomenclature,
        ?Tag $tag = null,
        ?Goal $parent = null,
        ?int $position = null,
        int $min = 0,
        ?int $max = null
    ) {
        $this->community = $community;
        $this->nomenclature = $nomenclature;
        $this->tag = $tag;
        $this->parent = $parent;
        $this->children = new ArrayCollection();
        $this->position = $position;
        $this->min = $min;
        $this->max = $max;

        $this->community->getGoals()->add($this);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }

    public function getNomenclature(): Nomenclature
    {
        return $this->nomenclature;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function getParent(): ?Goal
    {
        return $this->parent;
    }

    /**
     * @return Collection<int, Goal>
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }
}
