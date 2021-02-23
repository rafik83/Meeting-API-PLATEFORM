<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Repository;

use Proximum\Vimeet365\Domain\Entity\Company;

interface CompanyRepositoryInterface
{
    public function findOneById(int $id): ?Company;

    public function add(Company $company): void;
}
