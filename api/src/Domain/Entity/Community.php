<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Domain\Entity\Community\Step;

/**
 * @ORM\Entity()
 */
class Community
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @var string[] ISO 639-1 (or ISO 639-2 if not available)
     *
     * @ORM\Column(type="simple_array")
     */
    private array $languages;

    /**
     * @var string ISO 639-1 (or ISO 639-2 if not available)
     *
     * @ORM\Column(length=3)
     */
    private string $defaultLanguage;

    /**
     * @ORM\OneToMany(targetEntity=Nomenclature::class, mappedBy="community")
     *
     * @var Collection<int, Nomenclature>
     */
    private Collection $nomenclatures;

    /**
     * @ORM\OneToMany(targetEntity=Step::class, mappedBy="community", indexBy="position")
     * @ORM\OrderBy({"position" = "ASC"})
     *
     * @var Collection<int, Step>
     */
    private Collection $steps;

    /**
     * @ORM\OneToMany(targetEntity=Member::class, mappedBy="community")
     *
     * @var Collection<int, Member>
     */
    private Collection $members;

    public function __construct(string $name, array $languages = ['en'], string $defaultLanguage = 'en')
    {
        $this->name = $name;
        $this->languages = $languages;
        $this->defaultLanguage = $defaultLanguage;
        $this->nomenclatures = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->members = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function getDefaultLanguage(): string
    {
        return $this->defaultLanguage;
    }

    /**
     * @return Collection<int, Nomenclature>
     */
    public function getNomenclatures(): Collection
    {
        return $this->nomenclatures;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function getNextStep(Step $step): ?Step
    {
        return $this->getSteps()->get($step->getPosition() + 1);
    }

    public function join(Account $account): Member
    {
        $member = $account->getMemberFor($this);

        if ($member !== null) {
            return $member;
        }

        $member = new Member($this, $account);

        $this->members->add($member);

        return $member;
    }
}
