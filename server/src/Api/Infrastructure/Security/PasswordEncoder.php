<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Security;

use Proximum\Vimeet365\Core\Application\Security\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class PasswordEncoder implements PasswordEncoderInterface
{
    private EncoderFactoryInterface $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function encode(string $password): string
    {
        return $this->encoderFactory->getEncoder(SymfonyUser::class)->encodePassword($password, null);
    }
}
