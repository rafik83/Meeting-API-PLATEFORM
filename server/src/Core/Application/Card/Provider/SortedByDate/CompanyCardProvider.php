<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card\Provider\SortedByDate;

use Proximum\Vimeet365\Core\Application\Card\CompanyCard;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Proximum\Vimeet365\Core\Domain\Repository\CompanyRepositoryInterface;

class CompanyCardProvider implements CardProviderInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getCards(CardList $cardList): array
    {
        $companies = $this->companyRepository->getSortedByDate($cardList->getCommunity(), $cardList->getLimit());

        return array_map(static fn (Company $company): CompanyCard => new CompanyCard($company), $companies);
    }

    public function supports(CardList $cardList): bool
    {
        return \count($cardList->getCardTypes()) === 1
            && \in_array(CardType::get(CardType::COMPANY), $cardList->getCardTypes(), true)
            && $cardList->getSorting()->is(Sorting::DATE)
        ;
    }
}
