<?php

namespace App\Provider;


use Doctrine\ORM\EntityManager;

class PageProvider
{
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return null|\App\Entity\Page
     */
    public function getHomepage()
    {
        return $this->getRepository()->findOneBy(['titleSlug' => 'home']);
    }

    /**
     * @param $title
     * @return null|\App\Entity\Page
     */
    public function searchPage($title)
    {
        return $this->getRepository()->findOneBy(['title' => $title]);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getRepository()
    {
        return $this->em->getRepository('NekoWiki:Page');
    }
}
