<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community;

use Proximum\Vimeet365\Admin\Infrastructure\Validator as AssertVimeet365;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\Validator\Constraints as Assert;

class EditCommand
{
    /**
     * @Assert\NotBlank
     */
    public string $name;

    /**
     * @var string[]
     *
     * @Assert\All(
     *     @Assert\Language
     * )
     */
    public array $languages;

    /**
     * @Assert\NotBlank
     * @Assert\Language
     */
    public string $defaultLanguage;

    /**
     * @AssertVimeet365\NomenclatureBelongToCurrentCommunity()
     */
    public ?Nomenclature $skillNomenclature;

    /**
     * @AssertVimeet365\NomenclatureBelongToCurrentCommunity()
     */
    public ?Nomenclature $eventNomenclature;

    public function __construct(
        private Community $community
    ) {
        $this->name = $this->community->getName();
        $this->languages = $this->community->getLanguages();
        $this->defaultLanguage = $this->community->getDefaultLanguage();
        $this->skillNomenclature = $this->community->getSkillNomenclature();
        $this->eventNomenclature = $this->community->getEventNomenclature();
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }
}
