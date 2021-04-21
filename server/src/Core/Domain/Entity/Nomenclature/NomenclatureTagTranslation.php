<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class NomenclatureTagTranslation
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=NomenclatureTag::class, inversedBy="translations")
     */
    private NomenclatureTag $nomenclatureTag;

    /**
     * @ORM\Id
     * @ORM\Column
     */
    private string $locale;

    /**
     * @ORM\Column
     */
    private string $label;

    public function __construct(NomenclatureTag $nomenclatureTag, string $locale, string $label)
    {
        $this->nomenclatureTag = $nomenclatureTag;
        $this->locale = $locale;
        $this->label = $label;
    }

    public function getNomenclatureTag(): NomenclatureTag
    {
        return $this->nomenclatureTag;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
