<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Nomenclature;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureRepositoryInterface;

class CreateCommandHandler
{
    private NomenclatureRepositoryInterface $nomenclatureRepository;

    public function __construct(NomenclatureRepositoryInterface $nomenclatureRepository)
    {
        $this->nomenclatureRepository = $nomenclatureRepository;
    }

    public function __invoke(CreateCommand $command): Nomenclature
    {
        $nomenclature = new Nomenclature($command->reference, $command->community);

        $this->nomenclatureRepository->add($nomenclature);

        return $nomenclature;
    }
}
