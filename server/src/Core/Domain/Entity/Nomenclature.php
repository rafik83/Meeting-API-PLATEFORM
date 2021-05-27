<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Core\Infrastructure\Repository\NomenclatureRepository;

/**
 * @ORM\Entity(repositoryClass=NomenclatureRepository::class)
 */
class Nomenclature
{
    public const JOB_POSITION_NOMENCLATURE = 'job_position';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class, inversedBy="nomenclatures")
     */
    private ?Community $community;

    /**
     * @ORM\Column()
     */
    private string $reference;

    /**
     * @var Collection<int, NomenclatureTag>
     *
     * @ORM\OneToMany(targetEntity=NomenclatureTag::class, mappedBy="nomenclature", cascade={"all"})
     */
    private Collection $tags;

    public function __construct(string $reference, ?Community $community = null)
    {
        $this->tags = new ArrayCollection();
        $this->reference = $reference;

        if ($community !== null) {
            $this->community = $community;
            $this->community->getNomenclatures()->add($this);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommunity(): ?Community
    {
        return $this->community;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return Collection<int, NomenclatureTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @return Collection<int, NomenclatureTag>
     */
    public function getRootTags(): Collection
    {
        return $this->tags->filter(fn (NomenclatureTag $nomenclatureTag): bool => $nomenclatureTag->getParent() === null);
    }

    public function addTag(Tag $tag, ?Tag $parent = null, ?string $externalId = null): NomenclatureTag
    {
        $parentNomenclatureTag = null;
        if ($parent !== null) {
            $parentNomenclatureTag = $this->tags->filter(fn (NomenclatureTag $nomenclatureTag): bool => $nomenclatureTag->getTag() === $parent)->first();
            $parentNomenclatureTag = $parentNomenclatureTag === false ? null : $parentNomenclatureTag;
        }

        $nomenclatureTag = new NomenclatureTag($this, $tag, $parentNomenclatureTag, $externalId ?? $tag->getExternalId());

        $this->tags->add($nomenclatureTag);

        return $nomenclatureTag;
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

    public function findTag(Tag $tag): ?NomenclatureTag
    {
        $nomenclatureTag = $this->tags
            ->filter(fn (NomenclatureTag $nomenclatureTag): bool => $nomenclatureTag->getTag()->getId() === $tag->getId())
            ->first()
        ;

        if ($nomenclatureTag === false) {
            return null;
        }

        return $nomenclatureTag;
    }
}
