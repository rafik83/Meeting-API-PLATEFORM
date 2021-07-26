<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="meeting_slot")
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
    private \DateTimeImmutable $startDate;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    private \DateTimeImmutable $endDate;

    /**
     * @ORM\ManyToOne(targetEntity=Meeting::class, inversedBy="slots")
     */
    private Meeting $meeting;

    public function __construct(
        Meeting $meeting,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->meeting = $meeting;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getstartDate(): \DateTimeImmutable
    {
        return $this->startDate;
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
