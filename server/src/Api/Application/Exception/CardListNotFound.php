<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Exception;

class CardListNotFound extends \DomainException
{
    public function __construct(int $communityId, int $cardListId)
    {
        parent::__construct(
            sprintf('The cardList with id %d does not exist in the community %d', $cardListId, $communityId)
        );
    }
}
