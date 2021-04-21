<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function add(Account $account): void;

    public function findOneByEmail(string $email): ?Account;
}
