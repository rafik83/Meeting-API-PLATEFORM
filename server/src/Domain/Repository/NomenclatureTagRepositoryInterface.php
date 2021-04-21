<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Repository;

use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;

interface NomenclatureTagRepositoryInterface
{
    public function findOneByExternalId(string $id): ?NomenclatureTag;
}
