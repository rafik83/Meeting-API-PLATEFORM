<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Repository;

use Proximum\Vimeet365\Domain\Entity\Tag;

interface TagRepositoryInterface
{
    public function findOneByExternalId(string $id): ?Tag;

    public function getOneById(int $id): Tag;
}
