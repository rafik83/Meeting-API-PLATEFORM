<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application;

use Symfony\Component\Serializer\Annotation\Ignore;

interface ContextAwareMessageInterface
{
    /**
     * @Ignore
     */
    public function setContext(object $member): void;
}
