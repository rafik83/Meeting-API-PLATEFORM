<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Mail;

use Proximum\Vimeet365\Core\Domain\Entity\Account;

interface AccountRegistrationMailerInterface
{
    public function send(Account $account): void;
}
