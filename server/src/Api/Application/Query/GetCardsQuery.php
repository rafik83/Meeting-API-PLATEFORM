<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query;

class GetCardsQuery
{
    public function __construct(
        public int $communityId,
        public int $cardListId
    ) {
    }
}
