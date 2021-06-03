<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card;

use Proximum\Vimeet365\Core\Domain\Entity\Card\Card;
use Proximum\Vimeet365\Core\Domain\Entity\Member;

class MemberCard extends Card
{
    public function __construct(
        private Member $member
    ) {
    }

    public function getId(): int
    {
        return (int) $this->member->getId();
    }

    public function getName(): string
    {
        return $this->member->getAccount()->getLastName() . ' ' . $this->member->getAccount()->getFirstName();
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->member->getJoinedAt();
    }

    public function getMember(): Member
    {
        return $this->member;
    }
}
