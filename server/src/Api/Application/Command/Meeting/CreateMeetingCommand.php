<?php

namespace Proximum\Vimeet365\Api\Application\Command\Meeting;


use Proximum\Vimeet365\Common\Validator\Constraints\EntityReferenceDoesNotExist;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Meeting;
use Proximum\Vimeet365\Core\Domain\Entity\Slot;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Ignore;

class CreateMeetingCommand
{

    /**
     * @EntityReferenceExists(entity=Community::class, identityField="id")
     */
    public int $community;
//    /** @Ignore */
//    public Meeting $meeting;

//    /** @Ignore */
//    public Slot $slot;

    /**
     * @Assert\NotBlank
     */
     public string $message;

//    /** @Ignore */
//    public Member $participantFrom;
//
    /** @Ignore */
     public int $participantTo;

//    /**
//     * @Assert\NotBlank
//     */
//      public \DateTime $startDate;
//
//    /**
//     * @Assert\NotBlank
//     */
//     public \DateTime $endDate;


    /**
     * @Assert\Valid()
     * @Assert\Count(min=1, max=3)
     *
     * @var SlotDto[]
     */
    public array $slots;


//    public function __construct(Meeting $meeting,Slot $slot)
//    {
////        $this->meeting = $meeting;
////        $this->startDate = $slot->getDateDebut();
////        $this->endDate = $slot->getDateFin();
//    }


}
