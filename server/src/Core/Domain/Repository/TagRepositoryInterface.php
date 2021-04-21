<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Tag;

interface TagRepositoryInterface
{
    public function findOneByExternalId(string $id): ?Tag;

    public function getOneById(int $id): Tag;

    /**
     * Retrieve a list of tags indexed by id
     *
     * @param int[] $tagsId
     *
     * @return Tag[] indexed by tagId
     */
    public function findByIds(array $tagsId): array;
}
