<?php

namespace Nekland\NekoWiki\DataFixtures\ORM;

use Nekland\NekoWiki\Entity\User\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $roleUser  = new Role('ROLE_USER');
        $roleAdmin = new Role('ROLE_ADMIN');

        $roleUser->setParent($roleAdmin);

        $manager->persist($roleAdmin);
        $manager->persist($roleUser);
        $manager->flush();

        $this->addReference('role-user', $roleUser);
        $this->addReference('role-admin', $roleAdmin);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}
