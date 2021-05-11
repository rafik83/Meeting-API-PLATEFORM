<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Common\Pagination;

/**
 * @template T
 * @template-extends \Traversable<int, T>
 */
interface PaginatorInterface extends \Traversable, \Countable
{
    /**
     * @return array<int, T>
     */
    public function getItems(): array;

    public function getCurrentPage(): int;

    public function getLastPage(): int;

    public function getItemsPerPage(): int;

    /**
     * Gets the number of items in the whole collection.
     */
    public function getTotalCount(): int;

    public function hasNextPage(): bool;

    /**
     * @return bool True if the asked page doesn't exist (no items)
     */
    public function isPageOutOfBounds(): bool;
}
