<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Nomenclature;

use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCommand
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    public string $reference = '';

    public ?Community $community = null;
}
