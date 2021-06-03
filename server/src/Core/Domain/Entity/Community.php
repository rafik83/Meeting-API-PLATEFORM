<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;

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
     * @ORM\OneToMany(targetEntity=Member::class, mappedBy="community")
     *
     * @var Collection<int, Member>
     */
    private Collection $members;

    /**
     * @ORM\OneToMany(targetEntity=Goal::class, mappedBy="community", cascade={"persist"}, orphanRemoval=true)
     *
     * @var Collection<int, Goal>
     */
    private Collection $goals;

    /**
     * @ORM\OneToMany(targetEntity=CardList::class, mappedBy="community")
     * @ORM\OrderBy({"position" = "ASC"})
     *
     * @var Collection<int, CardList>
     */
    private Collection $cardLists;

    public function __construct(string $name, array $languages = ['en'], string $defaultLanguage = 'en')
    {
        $this->name = $name;
        $this->languages = $languages;
        $this->defaultLanguage = $defaultLanguage;
        $this->nomenclatures = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->goals = new ArrayCollection();
        $this->cardLists = new ArrayCollection();
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
     * @return Collection<int, Goal>
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function getMainGoal(): ?Goal
    {
        $mainGoal = $this->getGoals()->filter(fn (Goal $goal) => $goal->getParent() === null)->first();

        if ($mainGoal === false) {
            return null;
        }

        return $mainGoal;
    }

    /**
     * @return Collection<int, CardList>
     */
    public function getCardLists(): Collection
    {
        return $this->cardLists;
    }

    /**
     * @return Collection<int, CardList>
     */
    public function getPublishedCardLists(): Collection
    {
        return $this->getCardLists()->filter(fn (CardList $cardList): bool => $cardList->isPublished());
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

    public function __toString(): string
    {
        return $this->getName();
    }
}
