<?php

namespace App\DataFixtures\ORM;

use App\Entity\User\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 * @package App\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setSalt(md5(uniqid()));
        $user->setPassword($this->getEncodedPassword($user, 'admin'));
        $user->setEmail('admin@admin.com');

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @param  string $password
     * @return string
     */
    private function getEncodedPassword($user, $password)
    {
        return $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user)
            ->encodePassword($password, $user->getSalt())
        ;
    }
}
