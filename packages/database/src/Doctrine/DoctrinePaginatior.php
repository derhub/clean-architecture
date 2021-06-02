<?php

namespace Derhub\Shared\Database\Doctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use League\Fractal\Pagination\PaginatorInterface;

class DoctrinePaginatior implements PaginatorInterface
{
    public function __construct(private Paginator $paginator)
    {
    }

    public function getCount(): int
    {
        return $this->count = $this->count
            ?? $this->paginator->getIterator()->count();
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage ??= ($this->paginator->getQuery()
                    ->getFirstResult() / $this->paginator->getQuery()
                    ->getMaxResults()) + 1;
    }

    public function getLastPage(): float
    {
        return $this->lastPage ??= (int)ceil(
            $this->getTotal() / $this->paginator->getQuery()->getMaxResults()
        );
    }

    public function getPerPage(): int
    {
        return $this->paginator->getQuery()->getMaxResults();
    }

    public function getTotal(): int
    {
        return $this->total ??= count($this->paginator);
    }

    public function getUrl($page)
    {
        return 'not supported';
    }

    public function items()
    {
        return $this->paginator
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
            ;
    }
}
