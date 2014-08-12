<?php

namespace App\Search;


use App\Entity\PageRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

//@TODO : searchProvider ?
class RepositorySearch implements SearcherInterface
{
    /**
     * @var \App\Entity\PageRepository
     */
    private $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $query
     *
     * @return PagerFanta
     */
    public function find($query)
    {
        $adapter = new DoctrineORMAdapter($this->repository->createSearchContentQb($query));

        return new Pagerfanta($adapter);
    }
}
