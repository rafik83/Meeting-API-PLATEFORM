<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Dto\CommunityMedia;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Media\MediaTranslation;
use Symfony\Component\Validator\Constraints as Assert;

class TranslationDto
{
    /**
     * @Assert\NotBlank
     */
    public ?string $name = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $description = null;

    public ?string $ctaLabel = null;

    public ?string $ctaUrl = null;

    public function __construct(private string $language)
    {
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function updateFromEntity(?MediaTranslation $translation): void
    {
        if ($translation === null) {
            return;
        }

        $this->name = $translation->getName();
        $this->description = $translation->getDescription();
        $this->ctaLabel = $translation->getCtaLabel();
        $this->ctaUrl = $translation->getCtaUrl();
    }
}
