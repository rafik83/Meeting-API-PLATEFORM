<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Repository\CardListRepositoryInterface;

/**
 * @extends ServiceEntityRepository<CardList>
 */
class CardListRepository extends ServiceEntityRepository implements CardListRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardList::class);
    }

    public function findOneByCommunityAndId(int $communityId, int $cardListId): ?CardList
    {
        return $this->findOneBy([
            'community' => $communityId,
            'id' => $cardListId,
            'published' => true,
        ]);
    }
}
