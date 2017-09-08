<?php

/**
 * This file is part of the Neko-Wiki.
 *
 * (c) Maxime Veber <nek.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Event\Page;

use Symfony\Component\EventDispatcher\Event;

class PageEvent extends Event
{
    /**
     * @var \App\Entity\Page
     */
    private $page;

    public function __construct(\App\Entity\Page $page)
    {
        $this->page = $page;
    }

    /**
     * @return \App\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }
}
