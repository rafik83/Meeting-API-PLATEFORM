<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community\Media;

use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;

/**
 * @ORM\Entity
 * @ORM\Table(name="community_media_translation")
 */
class MediaTranslation
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Media::class, inversedBy="translations")
     */
    private Media $media;

    /**
     * @ORM\Id
     * @ORM\Column
     */
    private string $language;

    /**
     * @ORM\Column
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $ctaLabel;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $ctaUrl;

    public function __construct(
        Media $media,
        string $language,
        string $name,
        string $description,
        ?string $ctaLabel,
        ?string $ctaUrl
    ) {
        $this->media = $media;
        $this->language = $language;
        $this->name = $name;
        $this->description = $description;
        $this->ctaLabel = $ctaLabel;
        $this->ctaUrl = $ctaUrl;
    }

    public function getMedia(): Media
    {
        return $this->media;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCtaLabel(): ?string
    {
        return $this->ctaLabel;
    }

    public function getCtaUrl(): ?string
    {
        return $this->ctaUrl;
    }

    public function update(
        string $name,
        string $description,
        ?string $ctaLabel,
        ?string $ctaUrl
    ): void {
        $this->name = $name;
        $this->description = $description;
        $this->ctaLabel = $ctaLabel;
        $this->ctaUrl = $ctaUrl;
    }
}
