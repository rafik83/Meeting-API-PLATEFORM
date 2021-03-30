<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Security;

use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Component\Security\Core\User\UserInterface;

class SymfonyUser implements UserInterface, \Serializable
{
    private ?Account $account = null;

    /**
     * Used for serialization and refreshing users
     */
    private string $username;

    /**
     * Used for serialization and refreshing users
     */
    private ?string $password = null;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function getAccount(): Account
    {
        if ($this->account === null) {
            throw new \RuntimeException('Need to be refresh');
        }

        return $this->account;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): ?string
    {
        return $this->account !== null ? $this->account->getPassword() : $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->account !== null ? $this->account->getEmail() : $this->username;
    }

    public function eraseCredentials(): void
    {
    }

    /**
     * We don't need/want to serialize the domain user (Contact) instance inside the session,
     * so we just extract required data.
     */
    public function serialize(): string
    {
        return serialize([$this->getUsername(), $this->getPassword()]);
    }

    /**
     * When unserializing, we retrieve required data to authenticate the user back.
     * Contact instance will be set back when refreshing the user.
     *
     * @param string|mixed $serialized
     */
    public function unserialize($serialized): void
    {
        [$this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }
}
