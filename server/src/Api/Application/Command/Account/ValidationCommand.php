<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account;

use Proximum\Vimeet365\Core\Domain\Entity\Account;

class ValidationCommand
{
    public function __construct(public Account $account, public ?string $origin = '')
    {
    }
}
