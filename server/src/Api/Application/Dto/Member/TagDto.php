<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Dto\Member;

use Proximum\Vimeet365\Common\Validator\Constraints\EntityReferenceExists;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Symfony\Component\Validator\Constraints as Assert;

class TagDto
{
    /**
     * @EntityReferenceExists(entity=Tag::class, identityField="id")
     */
    public int $id;

    /**
     * @Assert\Range(min="0")
     */
    public ?int $priority;

    public function __construct(int $id, ?int $priority)
    {
        $this->id = $id;
        $this->priority = $priority;
    }
}
