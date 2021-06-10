<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Security;

interface PasswordHasherInterface
{
    public function hash(string $password): string;
}
