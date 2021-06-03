<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;

interface CardListRepositoryInterface
{
    public function findOneByCommunityAndId(int $communityId, int $cardListId): ?CardList;
}
