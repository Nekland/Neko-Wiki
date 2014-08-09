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
        $page2 = new Page();

        $page
            ->setTitle('Home')
            ->setContent('Hello i am the homepage. Change me by connect yourself.')
        ;
        $page2
            ->setTitle('Help')
            ->setContent(
<<<Markdown
Welcome to the help
===================

This page is editable as any other page !

Markdown
            )
        ;
        $page2
            ->translate('fr')
            ->setTitle('Aide')
            ->setContent(
<<<Markdown
Bienvenue dans l'aide
=====================

Cette page est modifiable comme n'importe quelle page !
Markdown
            )
        ;

        $manager->persist($page);
        $manager->persist($page2);
        $page->mergeNewTranslations();
        $page2->mergeNewTranslations();
        $manager->flush();
    }
}
