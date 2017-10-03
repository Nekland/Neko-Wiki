<?php

namespace Nekland\NekoWiki\Search;

use Nekland\NekoWiki\Entity\PageRepository;
use Nekland\NekoWiki\Language\LanguageManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Nekland\NekoWiki\Tools\Doctrine\DoctrineORMNativeQueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Search class using repository
 */
class RepositorySearch implements SearcherInterface
{
    /**
     * @var Nekland\NekoWiki\Entity\PageRepository
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
        $query = $this->repository->createSearchContentQbExceptLanguage($query, $language);

        $adapter = new DoctrineORMNativeQueryAdapter($query);

        return new Pagerfanta($adapter);
    }
}
