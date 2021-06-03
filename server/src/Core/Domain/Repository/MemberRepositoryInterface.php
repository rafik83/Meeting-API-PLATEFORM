<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Member;

interface MemberRepositoryInterface
{
    public function add(Member $account): void;

    public function findOneById(int $id): ?Member;

    /**
     * @return Member[]
     */
    public function getSortedByName(Community $community, int $limit): array;

    /**
     * @return Member[]
     */
    public function getSortedByDate(Community $community, int $limit): array;
}
