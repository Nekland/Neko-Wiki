<?php

namespace App\DataFixtures\ORM;

use App\Entity\Page;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPageData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $page = new Page();
        $page
            ->setTitle('Home')
            ->setContent('Hello i am the homepage')
        ;

        $manager->persist($page);
        $manager->flush();
    }
}
