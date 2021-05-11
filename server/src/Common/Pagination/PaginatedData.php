<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Common\Pagination;

/**
 * @template T
 * @template-extends \ArrayObject<int, T>
 */
class PaginatedData extends \ArrayObject
{
    private int $currentPage;
    private int $lastPage;
    private int $itemsPerPage;
    private int $numberOfItems;
    private int $totalNumberOfItems;

    /**
     * @param array<int, T> $items
     */
    public function __construct(
        array $items,
        int $currentPage,
        int $lastPage,
        int $itemsPerPage,
        int $totalNumberOfItems
    ) {
        parent::__construct($items);

        $this->currentPage = $currentPage;
        $this->lastPage = $lastPage;
        $this->itemsPerPage = $itemsPerPage;
        $this->totalNumberOfItems = $totalNumberOfItems;
        $this->numberOfItems = \count($items);
    }

    /**
     * @param PaginatorInterface<T> $paginator
     *
     * @return PaginatedData<T>
     */
    public static function createFromPaginator(PaginatorInterface $paginator, callable $callback = null): self
    {
        return new self(
            $callback !== null ? array_map($callback, $paginator->getItems()) : $paginator->getItems(),
            $paginator->getCurrentPage(),
            $paginator->getLastPage(),
            $paginator->getItemsPerPage(),
            $paginator->getTotalCount()
        );
    }

    /**
     * @return array<int, T>
     */
    public function getItems(): array
    {
        return iterator_to_array($this->getIterator());
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getNumberOfItems(): int
    {
        return $this->numberOfItems;
    }

    public function getTotalNumberOfItems(): int
    {
        return $this->totalNumberOfItems;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getPreviousPage(): ?int
    {
        return ($prev = $this->currentPage - 1) >= 1 ? $prev : null;
    }

    public function hasPreviousPage(): bool
    {
        return null !== $this->getPreviousPage();
    }

    public function getNextPage(): ?int
    {
        return ($next = $this->currentPage + 1) <= $this->lastPage ? $next : null;
    }

    public function hasNextPage(): bool
    {
        return null !== $this->getNextPage();
    }

    public function isLastPage(): bool
    {
        return $this->currentPage === $this->lastPage;
    }

    public function hasToPaginate(): bool
    {
        return $this->getLastPage() > 1;
    }
}
