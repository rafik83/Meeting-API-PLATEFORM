<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Security;

use Proximum\Vimeet365\Core\Domain\Entity\Admin;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SymfonyAdmin implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable
{
    private ?Admin $user = null;

    /**
     * Used for serialization and refreshing users
     */
    private string $username;

    /**
     * Used for serialization and refreshing users
     */
    private ?string $password = null;

    public function __construct(Admin $user)
    {
        $this->user = $user;
    }

    public function getUser(): Admin
    {
        if ($this->user === null) {
            throw new \RuntimeException('Need to be refresh');
        }

        return $this->user;
    }

    public function getRoles(): array
    {
        return ['ROLE_ADMIN'];
    }

    public function getPassword(): ?string
    {
        return $this->user !== null ? $this->user->getPassword() : $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    public function getUserIdentifier(): string
    {
        return $this->user !== null ? $this->user->getEmail() : $this->username;
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
        return serialize([$this->getUserIdentifier(), $this->getPassword()]);
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
