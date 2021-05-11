<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Nomenclature;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\Validator\Constraints as Assert;

class EditCommand
{
    public Nomenclature $nomenclature;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    public string $reference;

    public function __construct(Nomenclature $nomenclature)
    {
        $this->nomenclature = $nomenclature;

        $this->reference = $nomenclature->getReference();
    }
}
