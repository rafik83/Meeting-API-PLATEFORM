<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Infrastructure\Repository\AccountRepository;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column
     */
    private string $email;

    /**
     * @ORM\Column
     */
    private string $password;

    /**
     * @ORM\Column
     */
    private string $firstName;

    /**
     * @ORM\Column
     */
    private string $lastName;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $acceptedTermsAndConditionAt = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $vimeetId = null;

    public function __construct(
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        ?int $vimeetId = null
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->vimeetId = $vimeetId;

        $this->acceptedTermsAndCondition();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getVimeetId(): ?int
    {
        return $this->vimeetId;
    }

    public function setVimeetId(int $vimeetId): self
    {
        $this->vimeetId = $vimeetId;

        return $this;
    }

    public function acceptedTermsAndCondition(): void
    {
        $this->acceptedTermsAndConditionAt = new \DateTimeImmutable();
    }

    public function getAcceptedTermsAndConditionAt(): ?\DateTimeImmutable
    {
        return $this->acceptedTermsAndConditionAt;
    }
}
