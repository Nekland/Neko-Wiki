<?php

namespace Nekland\NekoWiki\Search;

interface SearcherInterface
{
    /**
     * @param string $query
     *
     * @return \PagerFanta\PagerFanta
     */
    public function find($query);

    /**
     * @param string $query
     * @param string $language
     * @return \PagerFanta\PagerFanta
     */
    public function findForLang($query, $language);

    /**
     * @param string $query
     * @param string $language
     * @return \PagerFanta\PagerFanta
     */
    public function findForAllLanguageExcept($query, $language);
}
