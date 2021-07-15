<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Domain\Repository;

use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList\Config;

/**
 * @template T
 */
interface CardItemRepositoryInterface
{
    /**
     * @return T[]
     */
    public function getSortedByName(Community $community, ?Config $config, int $limit): array;

    /**
     * @return T[]
     */
    public function getSortedByDate(Community $community, ?Config $config, int $limit): array;
}
