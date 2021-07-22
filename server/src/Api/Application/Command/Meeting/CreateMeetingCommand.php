<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Meeting;

use Proximum\Vimeet365\Api\Application\Dto\Meeting\SlotDto;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Symfony\Component\Validator\Constraints as Assert;

class CreateMeetingCommand
{
    /**
     * @EntityReferenceExists(entity=Member::class, identityField="id")
     */
    public int $participantTo;

    /**
     * @EntityReferenceExists(entity=Community::class, identityField="id")
     */
    public int $community;

    /**
     * @Assert\NotBlank
     */
    public string $message;

    /**
     * @Assert\Valid()
     * @Assert\Count(min=1, max=3)
     *
     * @var SlotDto[]
     */
    public array $slots;

    public function testDate(): void
    {
        foreach ($this->slots as $slot) {
            if ($slot->startDate >= $slot->endDate) {
                throw new \Proximum\Vimeet365\Api\Application\Exception\MeetingException('disability comparison ');
            }
        }
    }
}
