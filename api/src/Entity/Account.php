<?php

namespace Proximum\Vimeet365\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Proximum\Vimeet365\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

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
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $vimeetId;

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
