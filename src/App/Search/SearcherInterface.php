<?php

namespace App\Search;


interface SearcherInterface
{
    /**
     * @param  string $query
     * @return \PagerFanta\PagerFanta
     */
    public function find($query);
}
