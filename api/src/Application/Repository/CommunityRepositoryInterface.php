<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Repository;

use Proximum\Vimeet365\Entity\Community;

interface CommunityRepositoryInterface
{
    public function findById(int $id): ?Community;

    /**
     * @return Community[]
     */
    public function findAll();
}
