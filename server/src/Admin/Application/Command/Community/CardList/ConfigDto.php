<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList\Config;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList\MemberConfig;

abstract class ConfigDto
{
    public static function create(Community $community, ?Config $config): MemberConfigDto | null
    {
        if ($config instanceof MemberConfig) {
            return new MemberConfigDto($community, $config->getMainGoal());
        }

        return null;
    }
}
