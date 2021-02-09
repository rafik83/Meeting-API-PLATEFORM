<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

class AccountView
{
    public int $id;
    public string $email;
    public string $firstName;
    public string $lastName;
    public ?\DateTimeImmutable $acceptedTermsAndConditionAt;

    public function __construct(
        int $id,
        string $email,
        string $firstName,
        string $lastName,
        ?\DateTimeImmutable $acceptedTermsAndConditionAt
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->acceptedTermsAndConditionAt = $acceptedTermsAndConditionAt;
    }
}
