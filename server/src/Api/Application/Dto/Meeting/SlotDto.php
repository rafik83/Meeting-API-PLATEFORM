<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Dto\Meeting;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class SlotDto
{
     /**
     * @Assert\LessThan(propertyPath="endDate")
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    public \DateTimeImmutable $startDate;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    public \DateTimeImmutable $endDate;
}
