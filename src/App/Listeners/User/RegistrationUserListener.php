<?php

namespace App\Listeners\User;

use App\Event\User\UserEvent;
use Doctrine\ORM\EntityManager;

class RegistrationUserListener
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param UserEvent $event
     */
    public function onUserRegistration(UserEvent $event)
    {
        $roleRepository = $this->em->getRepository('App:User\Role');
        $role           = $roleRepository->getRole('ROLE_USER');

        $event->getUser()->addRole($role);
    }
}
