<?php

namespace Nekland\NekoWiki\Model\User\Persistence;


use Nekland\NekoWiki\Model\Content\Page;

interface PageRepositoryInterface
{
    public function findBySlug($slug);
    public function getHomepage(): Page;
}
