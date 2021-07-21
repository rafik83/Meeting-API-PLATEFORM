<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Domain\Entity\Meeting;

interface MeetingRepositoryInterface
{
    public function add(Meeting $meeting): void;

    //public function findOneById(int $id): ?Member;
}
