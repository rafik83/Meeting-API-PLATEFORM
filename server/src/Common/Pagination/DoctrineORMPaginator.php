<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Common\Pagination;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination as ORM;

/**
 * @template T
 *
 * @template-implements \IteratorAggregate<int, T>
 * @template-implements PaginatorInterface<T>
 */
final class DoctrineORMPaginator implements \IteratorAggregate, PaginatorInterface
{
    /** @var ORM\Paginator<T> */
    private ORM\Paginator $paginator;
    private Query $query;
    private int $firstResult;
    private int $maxResults;
    private int $totalItems;
    private ?\Traversable $iterator = null;

    /**
     * @param ORM\Paginator<T> $paginator
     */
    public function __construct(ORM\Paginator $paginator)
    {
        $this->paginator = $paginator;
        $this->query = $paginator->getQuery();
        $this->firstResult = (int) $this->query->getFirstResult();
        $this->maxResults = (int) $this->query->getMaxResults();

        if ($this->maxResults <= 0) {
            throw new \InvalidArgumentException('maxResult must be greater than 0.');
        }
    }

    /**
     * @return DoctrineORMPaginator<T>
     */
    public static function createFromQueryBuilder(
        QueryBuilder $qb,
        Pagination $pagination,
        bool $useOutputWalkers = true
    ): self {
        return new static((new ORM\Paginator($qb
            ->setFirstResult($pagination->getOffset())
            ->setMaxResults($pagination->getPerPage())
            ->getQuery(), false)
        )->setUseOutputWalkers($useOutputWalkers));
    }

    public function getItems(): array
    {
        return iterator_to_array($this->getIterator());
    }

    public function getCurrentPage(): int
    {
        return (int) floor($this->firstResult / $this->maxResults) + 1;
    }

    public function getLastPage(): int
    {
        return (int) max(ceil($this->getTotalCount() / $this->maxResults), 1);
    }

    public function getItemsPerPage(): int
    {
        return $this->maxResults;
    }

    public function getTotalCount(): int
    {
        return $this->totalItems ??= \count($this->paginator);
    }

    public function getIterator(): \Iterator
    {
        if (null === $this->iterator) {
            $this->iterator = $this->paginator->getIterator();
        }

        \assert($this->iterator instanceof \Iterator);

        return $this->iterator;
    }

    public function count(): int
    {
        $iterator = $this->getIterator();

        \assert($iterator instanceof \Countable);

        return \count($iterator);
    }

    public function hasNextPage(): bool
    {
        return $this->getCurrentPage() < $this->getLastPage();
    }

    public function isPageOutOfBounds(): bool
    {
        return $this->getCurrentPage() !== 1 && 0 === $this->count();
    }
}
