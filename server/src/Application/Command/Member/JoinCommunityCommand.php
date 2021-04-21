<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Member;

use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\EntityReferenceExists;

class JoinCommunityCommand
{
    /**
     * @EntityReferenceExists(entity=Community::class, identityField="id")
     */
    public int $community;
}
