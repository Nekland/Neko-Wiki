<?php

namespace Nekland\NekoWiki\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nekland\NekoWiki\Model\User\Role;

class RoleFixtures extends Fixture
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
}
