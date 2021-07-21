<?php


namespace Proximum\Vimeet365\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Slot;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\ManyToOne(targetEntity=Slot::class, inversedBy="meeting")
     * @ORM\JoinColumn(nullable=false)
     */
     private Collection $slot;

    public function __construct( Member $participantFrom, Member $participantTo, Collection $slot)
    {
        $this->participantFrom = $participantFrom;
        $this->participantTo = $participantTo;
        $this->slot = new ArrayCollection();
        $this->slot = $slot;

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
     * @return Collection|Slot[]
     */
    public function getSlot(): Slot
    {
        return $this->slot;
    }
    public function addSlot(Slot $slot): self
    {
        if (!$this->slot->contains($slot)) {
            $this->slot[] = $slot;
            $slot->setMeeting($this);
        }

        return $this;
    }

    public function removeSlot(Slot $slot): self
    {
        if ($this->slot->contains($slot)) {
            $this->slot->removeElement($slot);
            // set the owning side to null (unless already changed)
            if ($slot->getMeeting() === $this) {
                $slot->setMeeting(null);
            }
        }
    }


}
