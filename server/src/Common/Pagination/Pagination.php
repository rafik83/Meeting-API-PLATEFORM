<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Common\Pagination;

/**
 * Pagination components extracted from a request.
 */
class Pagination
{
    public const DEFAULT_PER_PAGE = 20;

    private int $page;
    private int $perPage;

    public function __construct(int $page = 1, ?int $perPage = null)
    {
        $this->page = $page;
        $this->perPage = $perPage ?? self::DEFAULT_PER_PAGE;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getOffset(): int
    {
        return max($this->page - 1, 0) * $this->perPage;
    }
}
