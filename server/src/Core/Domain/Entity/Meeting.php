<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;

/**
 * @ORM\Entity(repositoryClass=MeetingRepository::class)
 */
class Meeting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    /**
     * @ORM\Column(type="string", nullable= true)
     */
    private ?string $message;
    /**
     * @ORM\ManyToOne(targetEntity=Member::Class)
     * @ORM\JoinColumn(name="participant_from_id", referencedColumnName="id")
     */
    private Member $participantFrom;

    /**
     * @ORM\ManyToOne(targetEntity=Member::Class)
     * @ORM\JoinColumn(name="participant_to_id", referencedColumnName="id")
     */
    private Member $participantTo;

    /**
     * @ORM\OneToMany(targetEntity=Slot::class, mappedBy="meeting",cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Collection<int, Slot>
     */
    private Collection $slots;

    public function __construct(Member $participantFrom, Member $participantTo, string $message)
    {
        $this->participantFrom = $participantFrom;
        $this->participantTo = $participantTo;
        $this->slots = new ArrayCollection();
        $this->message = $message;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getParticipantFrom(): Member
    {
        return $this->participantFrom;
    }

    public function setParticipantFrom(Member $participantFrom): self
    {
        $this->participantFrom = $participantFrom;

        return $this;
    }

    public function getParticipantTo(): Member
    {
        return $this->participantTo;
    }

    public function setParticipantTo(Member $participantTo): self
    {
        $this->participantTo = $participantTo;

        return $this;
    }

    /**
     * @return Collection<int, Slot>
     */
    public function getSlots(): Collection
    {
        return $this->slots;
    }

    public function addSlot(\DateTimeImmutable $d1, \DateTimeImmutable $d2): void
    {
        $slot = new Slot($this, $d1, $d2);
    }
}
