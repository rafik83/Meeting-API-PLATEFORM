<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;

/**
 * @ORM\Entity
 */
class Nomenclature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Community $community;

    /**
     * @ORM\Column()
     */
    private string $name;

    /**
     * @var Collection<int, NomenclatureTag>
     *
     * @ORM\OneToMany(targetEntity=NomenclatureTag::class, mappedBy="community", cascade="ALL")
     */
    private Collection $tags;

    public function __construct(Community $community, string $name)
    {
        $this->tags = new ArrayCollection();
        $this->community = $community;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, NomenclatureTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag, ?Tag $parent = null): void
    {
        $parentNomenclatureTag = null;
        if ($parent !== null) {
            $parentNomenclatureTag = $this->tags->filter(fn (NomenclatureTag $nomenclatureTag): bool => $nomenclatureTag->getTag() === $parent)->first();
            $parentNomenclatureTag = $parentNomenclatureTag === false ? null : $parentNomenclatureTag;
        }

        $this->tags->add(new NomenclatureTag($this, $tag, $parentNomenclatureTag));
    }

    public function removeTag(Tag $tag): void
    {
        $nomenclatureTag = $this->tags->filter(fn (NomenclatureTag $nomenclatureTag): bool => $nomenclatureTag->getTag() === $tag)->first();

        if ($nomenclatureTag === false) {
            return;
        }

        $this->tags->removeElement($nomenclatureTag);

        /** @var NomenclatureTag $child */
        foreach ($nomenclatureTag->getChildren() as $child) {
            $this->removeTag($child->getTag());
        }
    }
}
