<?php

namespace Nekland\NekoWiki\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nekland\NekoWiki\Model\User\User;

/**
 * Class LoadUserData
 * @package Nekland\NekoWiki\DataFixtures\ORM
 */
class UserFixtures extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setSalt(md5(uniqid()));
        $user->setPassword('admin');
        $user->setEmail('admin@admin.com');
        $user->addRole($this->getReference('role-admin'));

        $manager->persist($user);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RoleFixtures::class,
        ];
    }
}
