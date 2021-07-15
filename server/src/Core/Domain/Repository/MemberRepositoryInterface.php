<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;

/**
 * @template-extends CardItemRepositoryInterface<Member>
 */
interface MemberRepositoryInterface extends CardItemRepositoryInterface
{
    public function add(Member $account): void;

    public function findOneById(int $id): ?Member;
}
