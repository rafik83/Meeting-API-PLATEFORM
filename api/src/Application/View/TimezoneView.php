<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\View;

class TimezoneView
{
    public string $code;
    public string $name;

    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }
}
