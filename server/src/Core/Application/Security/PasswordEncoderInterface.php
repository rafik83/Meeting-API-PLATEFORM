<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Security;

interface PasswordEncoderInterface
{
    public function encode(string $password): string;
}
