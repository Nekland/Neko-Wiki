<?php

namespace App\Search;


use App\Entity\PageRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

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

    public function find($query)
    {
        $adapter = new DoctrineORMAdapter($this->repository->createSearchQb($query));

        return new Pagerfanta($adapter);
    }
}
