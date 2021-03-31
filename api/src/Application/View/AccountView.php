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
    public ?string $avatar;
    public ?Company $company = null;

    /** @var MemberView[] */
    public array $members = [];

    public function __construct(
        int $id,
        string $email,
        string $firstName,
        string $lastName,
        ?\DateTimeImmutable $acceptedTermsAndConditionAt,
        ?string $avatar,
        ?Company $company,
        array $members = []
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->acceptedTermsAndConditionAt = $acceptedTermsAndConditionAt;
        $this->avatar = $avatar;
        $this->company = $company;
        $this->members = $members;
    }
}
