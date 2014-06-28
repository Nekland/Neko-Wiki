<?php

namespace Context;

use Knp\FriendlyContexts\Context\Context;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader as DataFixturesLoader;

/**
 * Class FixtureContext
 *
 * Drop db & create db & load fixtures for each feature load :)
 */
class FixtureContext extends Context
{
    /**
     * @BeforeSuite
     */
    public function setupFixtures()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em       = $this->get('doctrine')->getManager();
        $loader   = new DataFixturesLoader($this->container);
        $fixtures = $loader->getFixtures();

        if (!$fixtures) {
            return;
        }

        $purger   = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($fixtures);
    }
}
