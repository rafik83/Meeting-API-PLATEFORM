<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Core\Domain\Entity\Meeting;


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
     * @ORM\OneToMany(targetEntity=Slot::class, mappedBy="slot", cascade={"persist"}, orphanRemoval=true)
     *
     */
    private Meeting $meeting;

    public function __construct( ? Meeting $meeting ,?\DateTimeImmutable $starDate = null, ?\DateTimeImmutable $endDate  = null)
    {
        date_default_timezone_set("Europe/Madrid");
        $this->starDate = $startDate ?? new \DateTimeImmutable();
        $this->endDate = $endDate ?? new \DateTimeImmutable();
        $this->meeting = $meeting ;


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeeting(): ?Meeting
    {
        return $this->meeting;
    }

    public function getDateDebut(): \DateTimeImmutable
    {
        return $this->starDate;
    }

    public function setMeeting(? Meeting $meeting): self
    {
        $this->meeting = $meeting;

        return $this;
    }

    public function setDateDebut(\DateTimeImmutable $starDate): self
    {
        $this->starDate = $starDate;

        return $this;
    }

    public function getDateFin(): \DateTimeImmutable
    {
        return $this->endDate;
    }
    public function setDateFin(\DateTimeImmutable $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }




}
