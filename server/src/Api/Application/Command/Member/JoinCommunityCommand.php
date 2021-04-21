<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Member;

use Proximum\Vimeet365\Common\Validator\Constraints\EntityReferenceExists;
use Proximum\Vimeet365\Core\Domain\Entity\Community;

class JoinCommunityCommand
{
    /**
     * @EntityReferenceExists(entity=Community::class, identityField="id")
     */
    public int $community;
}
