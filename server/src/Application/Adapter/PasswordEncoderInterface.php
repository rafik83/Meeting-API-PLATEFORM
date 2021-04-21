<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Adapter;

interface PasswordEncoderInterface
{
    public function encode(string $password): string;
}
