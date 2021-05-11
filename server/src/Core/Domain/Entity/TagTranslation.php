<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class TagTranslation
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="translations")
     */
    private Tag $tag;

    /**
     * @ORM\Id
     * @ORM\Column
     */
    private string $locale;

    /**
     * @ORM\Column
     */
    private string $label;

    public function __construct(Tag $tag, string $locale, string $label)
    {
        $this->tag = $tag;
        $this->locale = $locale;
        $this->label = $label;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function __toString(): string
    {
        return $this->getLabel();
    }
}
