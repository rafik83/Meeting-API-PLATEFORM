<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Proximum\Vimeet365\Infrastructure\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(nullable=true, unique=true)
     */
    private ?string $externalId;

    /**
     * @var ArrayCollection<string, TagTranslation>
     *
     * @ORM\OneToMany(targetEntity=TagTranslation::class, mappedBy="tag", indexBy="locale", cascade="ALL")
     * @ORM\JoinColumn(nullable=false)
     */
    private Collection $translations;

    public function __construct(?string $externalId = null)
    {
        $this->externalId = $externalId;
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * @return Collection<string, TagTranslation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function setLabel(string $label, ?string $locale = null): void
    {
        $locale = \Locale::getPrimaryLanguage($locale ?? \Locale::getDefault());

        $this->getTranslations()->set($locale, new TagTranslation($this, $locale, $label));
    }

    public function getLabel(?string $locale = null): ?string
    {
        $locale = \Locale::getPrimaryLanguage($locale ?? \Locale::getDefault());

        $translation = $this->getTranslations()->get($locale);

        if ($translation === null) {
            return null;
        }

        return $translation->getLabel();
    }
}
