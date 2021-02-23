<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Company
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
    private string $name;

    /**
     * @ORM\Column(length=2)
     */
    private string $countryCode;

    /**
     * @ORM\Column
     */
    private string $website;

    /**
     * @ORM\Column(length=300)
     */
    private string $activity;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $logo;

    public function __construct(
        string $name,
        string $countryCode,
        string $website,
        string $activity,
        ?string $logo = null
    ) {
        $this->name = $name;
        $this->countryCode = $countryCode;
        $this->website = $website;
        $this->activity = $activity;
        $this->logo = $logo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getActivity(): string
    {
        return $this->activity;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    public function update(string $name, string $countryCode, string $website, string $activity): void
    {
        $this->name = $name;
        $this->countryCode = $countryCode;
        $this->website = $website;
        $this->activity = $activity;
    }
}
