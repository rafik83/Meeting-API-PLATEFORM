<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Vimeet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table("event")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $domain;

    /**
     * @ORM\Column(type="string")
     */
    private string $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }
}
