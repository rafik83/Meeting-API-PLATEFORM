<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="slot")
 */
class Slot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    private \DateTimeImmutable $starDate;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    private \DateTimeImmutable $endDate;

    /**
     * @ORM\ManyToOne(targetEntity=Meeting::class, inversedBy="slot")
     */
    private Meeting $meeting;

    public function __construct(Meeting $meeting, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate)
    {
        $this->starDate = $startDate; //new \DateTimeImmutable();
        $this->endDate = $endDate; // new \DateTimeImmutable();
        $this->meeting = $meeting; //new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getstartDate(): \DateTimeImmutable
    {
        return $this->starDate;
    }

    public function getendDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getMeeting(): Meeting
    {
        return $this->meeting;
    }
}
