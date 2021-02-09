<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Adapter;

use Proximum\Vimeet365\Domain\Entity\Account;

interface CurrentAccountProviderInterface
{
    public function getAccount(): ?Account;
}
