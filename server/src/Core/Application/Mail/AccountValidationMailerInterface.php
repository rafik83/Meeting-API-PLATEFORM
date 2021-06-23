<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Mail;

use Proximum\Vimeet365\Core\Domain\Entity\Account;

interface AccountValidationMailerInterface
{
    public function send(Account $account, string $token, string $origin): void;
}
