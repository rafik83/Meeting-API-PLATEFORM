<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account;

use Proximum\Vimeet365\Common\Validator\Constraints\EntityReferenceDoesNotExist;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
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
