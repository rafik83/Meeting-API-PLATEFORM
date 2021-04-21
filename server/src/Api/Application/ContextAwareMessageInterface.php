<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application;

use Symfony\Component\Serializer\Annotation\Ignore;

interface ContextAwareMessageInterface
{
    /**
     * @Ignore
     */
    public function setContext(object $object): void;
}
