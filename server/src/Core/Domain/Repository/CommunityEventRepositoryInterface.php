<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;

interface CommunityEventRepositoryInterface
{
    /**
     * @return Event[]
     */
    public function getSortedByName(Community $community, int $limit): array;

    /**
     * @return Event[]
     */
    public function getSortedByDate(Community $community, int $limit): array;
}
