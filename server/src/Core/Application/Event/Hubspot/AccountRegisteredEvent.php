<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Event\Hubspot;

use Proximum\Vimeet365\Core\Domain\Entity\Account;

class AccountRegisteredEvent
{
    public string $email;

    public function __construct(Account $account)
    {
        $this->email = $account->getEmail();
    }
}
