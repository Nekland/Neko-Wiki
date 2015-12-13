<?php

/**
 * This file is part of the Neko-Wiki.
 *
 * (c) Maxime Veber <nek.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Search;


use App\Entity\PageRepository;
use App\Event\Page\Events;
use App\Event\Page\PageEvent;
use Elastica\Client;
use Elastica\Query;
use Elastica\Search;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ElasticSearch implements SearcherInterface, EventSubscriberInterface
{
    /**
     * @var TransformedFinder
     */
    private $finder;

    public function __construct(TransformedFinder $finder, PageRepository $repository)
    {
        $this->finder = $finder;
    }

    /**
     * @param string $queryString
     *
     * @return \PagerFanta\PagerFanta
     */
    public function find($queryString)
    {

        /*
        $query = new Query\Filtered();
        $query->setQuery((new Query())->setFields(['title', 'content']));
        $query->setFilter();
        */
        $query = new Query();
        $qb = new \Elastica\QueryBuilder();
        $query->setQuery($qb->query()->query_string($queryString));

        return $this->finder->findPaginated($query);
    }

    /**
     * @param string $queryString
     * @param string $language
     * @return \PagerFanta\PagerFanta
     */
    public function findForLang($queryString, $language)
    {
        $query = new Query();
        $qb = new \Elastica\QueryBuilder();
        $query->setQuery(
            $qb->query()->filtered(
                $qb->query()->query_string('page'),
                $qb->filter()->term(['locale' => $language])
            )
        );

        return $this->finder->findPaginated($query);
    }

    /**
     * @param string $query
     * @param string $language
     * @return \PagerFanta\PagerFanta
     */
    public function findForAllLanguageExcept($query, $language)
    {
        $query = new Query();
        $qb = new \Elastica\QueryBuilder();
        $query->setQuery(
            $qb->query()->filtered(
                $qb->query()->query_string('page'),
                $qb->filter()->bool_not($qb->filter()->term(['locale' => $language]))
            )
        );

        $foo = $this->finder->findPaginated($query);
        var_dump($foo);
        foreach($foo as $foobar) {
            var_dump($foobar);
        }
        exit;

        return $this->finder->findPaginated($query);
    }

    public function onPagePersist(PageEvent $event)
    {
        $page = $event->getPage();
    }

    public static function getSubscribedEvents()
    {
        return [Events::ON_PAGE_PERSIST => 'onPagePersist'];
    }
}
