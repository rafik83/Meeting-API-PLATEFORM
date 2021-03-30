<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;

interface NomenclatureRepositoryInterface
{
    public function findOneById(int $id): ?Nomenclature;

    public function findJobPositionNomenclature(): ?Nomenclature;
}
