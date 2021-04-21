<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Security;

use Proximum\Vimeet365\Core\Domain\Entity\Account;

interface CurrentAccountProviderInterface
{
    public function getAccount(): ?Account;
}
