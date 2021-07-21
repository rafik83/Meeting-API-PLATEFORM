<?php

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Meeting;

interface MeetingRepositoryInterface
{
    public function add(Meeting $meeting): void;
}
