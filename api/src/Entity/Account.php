<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Repository\AccountRepository;

/**
 * @ApiResource(attributes={"pagination_items_per_page"=10})
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
     * @ORM\Column(type="integer")
     */
    private ?int $vimeetId = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
