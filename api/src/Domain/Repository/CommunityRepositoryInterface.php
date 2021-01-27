<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Repository;

use Proximum\Vimeet365\Domain\Entity\Community;

interface CommunityRepositoryInterface
{
    public function findById(int $id): ?Community;

    /**
     * @return Community[]
     */
    public function findAll();
}
