<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Security;

use Proximum\Vimeet365\Core\Domain\Entity\Account;

interface AccountValidationTokenStorageInterface
{
    public function generateToken(Account $account): string;

    public function exists(Account $account, string $token): bool;
}
