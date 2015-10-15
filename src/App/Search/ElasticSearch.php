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


use App\Event\Page\Events;
use App\Event\Page\PageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ElasticSearch implements SearcherInterface, EventSubscriberInterface
{
    /**
     * @param string $query
     *
     * @return \PagerFanta\PagerFanta
     */
    public function find($query)
    {
        // TODO: Implement find() method.
    }

    /**
     * @param string $query
     * @param string $language
     * @return \PagerFanta\PagerFanta
     */
    public function findForLang($query, $language)
    {
        // TODO: Implement findForLang() method.
    }

    /**
     * @param string $query
     * @param string $language
     * @return \PagerFanta\PagerFanta
     */
    public function findForAllLanguageExcept($query, $language)
    {
        // TODO: Implement findForAllLanguageExcept() method.
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
