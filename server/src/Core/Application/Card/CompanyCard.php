<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card;
use Proximum\Vimeet365\Core\Domain\Entity\Company;

class CompanyCard extends Card
{
    public function __construct(
        private Company $company
    ) {
    }

    public function getId(): int
    {
        return (int) $this->company->getId();
    }

    public function getName(): string
    {
        return $this->company->getName();
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->company->getCreatedAt();
    }

    public function getCompany(): Company
    {
        return $this->company;
    }
}
