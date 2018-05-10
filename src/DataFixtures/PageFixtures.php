<?php

namespace Nekland\NekoWiki\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nekland\NekoWiki\Model\Content\Page;

class PageFixtures extends Fixture
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
        $page3 = new Page();
        $page4 = new Page();

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

        $page3
            ->translate('fr')
            ->setTitle('Foo Bar')
            ->setContent('Un contenu aléatoire.')
        ;

        $page4
            ->setTitle('Something in english')
            ->setContent('I\'m a random page but i\'m in english !')
        ;

        $manager->persist($page);
        $manager->persist($page2);
        $manager->persist($page3);
        $manager->persist($page4);
        $page->mergeNewTranslations();
        $page2->mergeNewTranslations();
        $page3->mergeNewTranslations();
        $page4->mergeNewTranslations();
        $manager->flush();
    }
}
