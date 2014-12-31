<?php

namespace App\Search;


use App\Entity\PageRepository;
use App\Language\LanguageManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\DoctrineORMNativeQueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Search class using repository
 */
class RepositorySearch implements SearcherInterface
{
    /**
     * @var \App\Entity\PageRepository
     */
    private $repository;

    /**
     * @var LanguageManager
     */
    private $languageManager;

    public function __construct(PageRepository $repository, LanguageManager $languageManager)
    {
        $this->repository = $repository;
        $this->languageManager = $languageManager;
    }

    public function find($query)
    {
        $adapter = new DoctrineORMAdapter($this->repository->createSearchContentQb($query));

        return new Pagerfanta($adapter);
    }

    public function findForLang($query, $language)
    {
        $adapter = new DoctrineORMNativeQueryAdapter($this->repository->createSearchContentQbForLanguage($query, $language));

        return new Pagerfanta($adapter);
    }

    public function findForAllLanguageExcept($query, $language)
    {
        $query = $this->repository->createSearchContentQbExeptLanguage($query, $language);
        var_dump($query->getResult()[0]->getCurrentLocale());exit;

        $adapter = new DoctrineORMNativeQueryAdapter($this->repository->createSearchContentQbExeptLanguage($query, $language));

        return new Pagerfanta($adapter);
    }
}
