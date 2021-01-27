<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity\Nomenclature;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Tag;

/**
 * @ORM\Entity
 */
class NomenclatureTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Nomenclature::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Nomenclature $nomenclature;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Tag $tag;

    /**
     * @ORM\ManyToOne(targetEntity=NomenclatureTag::class, inversedBy="children")
     */
    private ?NomenclatureTag $parent;

    /**
     * @ORM\OneToMany(targetEntity=NomenclatureTag::class, mappedBy="parent")
     *
     * @var Collection<int, NomenclatureTag>
     */
    private Collection $children;

    public function __construct(Nomenclature $nomenclature, Tag $tag, ?NomenclatureTag $parent = null)
    {
        $this->nomenclature = $nomenclature;
        $this->tag = $tag;

        $this->children = new ArrayCollection();
        $this->parent = $parent;

        if ($parent !== null) {
            $parent->addChild($this);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomenclature(): Nomenclature
    {
        return $this->nomenclature;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }

    public function getParent(): ?NomenclatureTag
    {
        return $this->parent;
    }

    /**
     * @return Collection<int, NomenclatureTag>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(NomenclatureTag $nomenclatureTag): void
    {
        if ($this->children->contains($nomenclatureTag)) {
            return;
        }

        $this->children->add($nomenclatureTag);
    }
}
