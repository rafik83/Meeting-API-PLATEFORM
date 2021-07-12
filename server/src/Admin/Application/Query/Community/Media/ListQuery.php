<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Query\Community\Media;

use Proximum\Vimeet365\Common\Pagination\Pagination;

class ListQuery
{
    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(
        public Pagination $pagination,
        public array $filters,
        public ?string $sort = null,
        public string $sortDirection = 'ASC'
    ) {
    }
}
