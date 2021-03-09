<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity\Nomenclature;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Tag;
use Proximum\Vimeet365\Domain\Entity\TagTranslation;

/**
 * @ORM\Entity(repositoryClass="Proximum\Vimeet365\Infrastructure\Repository\NomenclatureTagRepository")
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
     * @ORM\ManyToOne(targetEntity=Nomenclature::class, inversedBy="tags")
     * @ORM\JoinColumn(nullable=false)
     */
    private Nomenclature $nomenclature;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, cascade="PERSIST")
     * @ORM\JoinColumn(nullable=false)
     */
    private Tag $tag;

    /**
     * @ORM\ManyToOne(targetEntity=NomenclatureTag::class, inversedBy="children")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private ?NomenclatureTag $parent;

    /**
     * @ORM\OneToMany(targetEntity=NomenclatureTag::class, mappedBy="parent")
     *
     * @var Collection<int, NomenclatureTag>
     */
    private Collection $children;

    /** @ORM\Column(nullable=true) */
    private ?string $externalId;

    /**
     * @var Collection<string, NomenclatureTagTranslation>
     *
     * @ORM\OneToMany(targetEntity=NomenclatureTagTranslation::class, mappedBy="nomenclatureTag", indexBy="locale", cascade="ALL")
     * @ORM\JoinColumn(nullable=false)
     */
    private Collection $translations;

    public function __construct(Nomenclature $nomenclature, Tag $tag, ?NomenclatureTag $parent = null, ?string $externalId = null)
    {
        $this->nomenclature = $nomenclature;
        $this->tag = $tag;

        $this->children = new ArrayCollection();
        $this->parent = $parent;
        if ($parent !== null) {
            $parent->addChild($this);
        }

        $this->externalId = $externalId;

        $this->translations = new ArrayCollection();
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

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
    }

    /**
     * @return Collection<string, NomenclatureTagTranslation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function getLabel(?string $locale = null): ?string
    {
        $locale = \Locale::getPrimaryLanguage($locale ?? \Locale::getDefault());

        /** @var NomenclatureTagTranslation|null $translation */
        $translation = $this->translations->get($locale);
        if ($translation !== null) {
            return $translation->getLabel();
        }

        /** @var TagTranslation|null $translation */
        $translation = $this->getTag()->getTranslations()->get($locale);
        if ($translation !== null) {
            return $translation->getLabel();
        }

        $defaultLanguage = $this->getNomenclature()->getCommunity()->getDefaultLanguage();
        if ($locale !== $defaultLanguage) {
            return $this->getLabel($defaultLanguage);
        }

        return null;
    }

    public function setLabel(string $label, ?string $locale = null): void
    {
        $locale = \Locale::getPrimaryLanguage($locale ?? \Locale::getDefault());

        $tagTranslation = $this->getTag()->getTranslations()->get($locale);

        if ($tagTranslation !== null && $tagTranslation->getLabel() === $label) {
            // we want to use the default translation
            $this->translations->remove($locale);

            return;
        }

        if ($tagTranslation === null) {
            // there are no default translation for this locale
            $this->getTag()->setLabel($label, $locale);
        }

        $this->translations->set($locale, new NomenclatureTagTranslation($this, $locale, $label));
    }
}
