<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Query\HubSpot;

class SearchCompaniesQuery
{
    public string $domain;
    public int $limit;

    public function __construct(string $domain, int $limit)
    {
        $this->domain = $domain;
        $this->limit = $limit;
    }
}
