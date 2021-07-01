<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal\GoalMatching;
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
    private ?int $id = null;

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
     * @ORM\OneToMany(targetEntity=Goal::class, mappedBy="parent", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"position": "ASC"})
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

    /**
     * @var Collection<int, GoalMatching>
     *
     * @ORM\OneToMany(targetEntity=GoalMatching::class, mappedBy="goal", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"from" = "ASC", "priority" = "ASC"})
     */
    private Collection $matching;

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
        $this->matching = new ArrayCollection();
        $this->position = $position;
        $this->min = $min;
        $this->max = $max;

        $this->community->getGoals()->add($this);
        if ($this->parent !== null) {
            $this->parent->getChildren()->add($this);
        }
    }

    public function getId(): ?int
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

    /**
     * @return Collection<int, GoalMatching>
     */
    public function getMatching()
    {
        return $this->matching;
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

    public function updateAsMain(
        Nomenclature $nomenclature,
        int $min,
        ?int $max = null,
        ?int $position = null
    ): void {
        $this->nomenclature = $nomenclature;
        $this->min = $min;
        $this->max = $max;
        $this->position = $position;
    }

    public function updateAsChild(int $min, ?int $max = null, ?int $position = null): void
    {
        $this->min = $min;
        $this->max = $max;
        $this->position = $position;
    }

    public function createChild(Nomenclature $nomenclature, Tag $tag): Goal
    {
        return new Goal($this->community, $nomenclature, $tag, $this);
    }

    public function findChildrenWithNomenclatureAndTag(Nomenclature $nomenclature, Tag $tag): ?Goal
    {
        $found = $this->getChildren()->filter(
            function (Goal $goal) use ($nomenclature, $tag): bool {
                return $goal->getNomenclature()->getId() === $nomenclature->getId()
                    && $goal->getTag() !== null
                    && $goal->getTag()->getId() === $tag->getId()
                ;
            }
        )->first();

        if ($found === false) {
            return null;
        }

        return $found;
    }
}
