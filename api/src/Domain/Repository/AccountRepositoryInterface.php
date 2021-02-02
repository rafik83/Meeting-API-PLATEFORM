<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Repository;

use Proximum\Vimeet365\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function add(Account $account): void;
}
