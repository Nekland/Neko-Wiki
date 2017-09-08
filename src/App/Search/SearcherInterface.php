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
