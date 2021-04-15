<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Security;

use Proximum\Vimeet365\Application\Adapter\PasswordEncoderInterface;
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
        return $this->encoderFactory->getEncoder(User::class)->encodePassword($password, null);
    }
}
