<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Hubspot\Model;

use Proximum\Vimeet365\Core\Domain\Entity\Account;

class Contact
{
    public ?string $id;

    /** @var array<string, string> */
    public array $properties;

    public function __construct(?string $id, array $properties = [])
    {
        $this->id = $id;
        $this->properties = $properties;
    }

    public static function fromAccount(Account $account): self
    {
        return new self($account->getHubspotId(), [
            'email' => $account->getEmail(),
            'firstname' => $account->getFirstName(),
            'lastname' => $account->getLastName(),
        ]);
    }
}
