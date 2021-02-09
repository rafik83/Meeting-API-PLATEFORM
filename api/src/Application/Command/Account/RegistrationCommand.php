<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Account;

use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\EntityReferenceDoesNotExist;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationCommand
{
    /**
     * @Assert\Email
     * @Assert\NotBlank
     * @EntityReferenceDoesNotExist(
     *     entity=Account::class,
     *     identityField="email"
     * )
     */
    public string $email;

    /**
     * @Assert\NotBlank
     */
    public string $password;

    /**
     * @Assert\NotBlank
     */
    public string $firstName;

    /**
     * @Assert\NotBlank
     */
    public string $lastName;

    /**
     * @Assert\IsTrue()
     */
    public bool $acceptedTermsAndCondition = false;
}
