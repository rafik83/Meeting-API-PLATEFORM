<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Security;

use Proximum\Vimeet365\Core\Application\Security\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class PasswordHasher implements PasswordHasherInterface
{
    private PasswordHasherFactoryInterface $encoderFactory;

    public function __construct(PasswordHasherFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function hash(string $password): string
    {
        return $this->encoderFactory->getPasswordHasher(SymfonyUser::class)->hash($password);
    }
}
