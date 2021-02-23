<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

use Proximum\Vimeet365\Domain\Entity\Company;

class AccountView
{
    public int $id;
    public string $email;
    public string $firstName;
    public string $lastName;
    public ?\DateTimeImmutable $acceptedTermsAndConditionAt;
    public ?Company $company = null;

    public function __construct(
        int $id,
        string $email,
        string $firstName,
        string $lastName,
        ?\DateTimeImmutable $acceptedTermsAndConditionAt,
        ?Company $company
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->acceptedTermsAndConditionAt = $acceptedTermsAndConditionAt;
        $this->company = $company;
    }
}
