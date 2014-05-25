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
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getRepository()
    {
        return $this->em->getRepository('App:Page');
    }
}
