<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Query\Community\CardList;

use Proximum\Vimeet365\Common\Pagination\Pagination;

class ListQuery
{
    public Pagination $pagination;

    /** @var array<string, mixed> */
    public array $filters;

    public ?string $sort;
    public string $sortDirection;

    public function __construct(Pagination $pagination, array $filters, ?string $sort = null, string $sortDirection = 'ASC')
    {
        $this->pagination = $pagination;
        $this->filters = $filters;
        $this->sort = $sort;
        $this->sortDirection = $sortDirection;
    }
}
