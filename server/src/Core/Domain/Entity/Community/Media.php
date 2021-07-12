<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Community;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media\MediaTranslation;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media\MediaType;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Infrastructure\Repository\CommunityMediaRepository;

/**
 * @ORM\Entity(repositoryClass=CommunityMediaRepository::class)
 * @ORM\Table(name="community_media")
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class, inversedBy="medias")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Community $community;

    /**
     * @ORM\Column(type="community_media_type")
     */
    private MediaType $mediaType;

    /**
     * Indexed by language
     *
     * @var Collection<string, MediaTranslation>
     *
     * @ORM\OneToMany(targetEntity=MediaTranslation::class, mappedBy="media", indexBy="language", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
     */
    private Collection $translations;

    /**
     * @var Collection<int, Tag>
     *
     * @ORM\ManyToMany(targetEntity=Tag::class, orphanRemoval=true)
     * @ORM\JoinTable(name="community_media_tag")
     */
    private Collection $tags;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $video = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $published = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $processed = false;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @param Tag[] $tags
     */
    public function __construct(Community $community, MediaType $mediaType, array $tags)
    {
        $this->community = $community;
        $this->mediaType = $mediaType;
        $this->translations = new ArrayCollection();

        $this->tags = new ArrayCollection($tags);

        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }

    public function getMediaType(): MediaType
    {
        return $this->mediaType;
    }

    /**
     * @return Collection<string, MediaTranslation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function setTranslation(
        string $language,
        string $name,
        string $description,
        ?string $ctaLabel,
        ?string $ctaUrl
    ): void {
        /** @var MediaTranslation|null $existingTranslation */
        $existingTranslation = $this->translations->get($language);

        if ($existingTranslation === null) {
            $this->translations->set($language, new MediaTranslation(
                $this,
                $language,
                $name,
                $description,
                $ctaLabel,
                $ctaUrl));
        } else {
            $existingTranslation->update(
                $name,
                $description,
                $ctaLabel,
                $ctaUrl
            );
        }
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): void
    {
        $this->video = $video;
        $this->processed = false;
    }

    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function isProcessed(): bool
    {
        return $this->processed;
    }

    public function setProcessed(bool $processed): void
    {
        $this->processed = $processed;
    }

    public function getTranslation(?string $language = null): ?MediaTranslation
    {
        return $this->translations->get($language ?? \Locale::getDefault());
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function update(MediaType $mediaType, array $tags): void
    {
        $this->mediaType = $mediaType;

        $this->tags = new ArrayCollection($tags);
    }
}
