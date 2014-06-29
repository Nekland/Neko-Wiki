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
     * Loads fixtures from bundles in application
     *
     * @BeforeBackground
     */
    public function setupFixtures()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em       = $this->get('doctrine')->getManager();
        /** @var \Symfony\Component\HttpKernel\KernelInterface $kernel */
        $kernel   = $this->getKernel();

        if (!$kernel) {
            return;
        }

        $paths = [];
        foreach ($kernel->getBundles() as $bundle) {
            $paths[] = $bundle->getPath().'/DataFixtures/ORM';
        }

        $loader   = new DataFixturesLoader($kernel->getContainer());
        foreach ($paths as $path) {
            if (is_dir($path)) {
                $loader->loadFromDirectory($path);
            }
        }
        $fixtures = $loader->getFixtures();

        if (!$fixtures) {
            return;
        }

        $purger   = new ORMPurger($em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);

        $executor = new ORMExecutor($em, $purger);
        $executor->execute($fixtures);

        $em->flush();
        //exit('hello');
    }
}
