<?php

namespace spec\App\Listeners\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegistrationUserListenerSpec extends ObjectBehavior
{
    /**
     * @param \Doctrine\ORM\EntityManager $em
     */
    function let($em)
    {
        $this->beConstructedWith($em);
    }

    /**
     * @param \App\Event\User\UserEvent       $event
     * @param \App\Entity\User\User           $user
     * @param \App\Entity\User\Role           $role
     * @param \App\Entity\User\RoleRepository $repository
     */
    function it_should_add_basic_role_to_user($event, $user, $role, $repository, $em)
    {
        $event->getUser()->willReturn($user);

        $em->getRepository(Argument::any())->willReturn($repository);
        $repository->getRole(Argument::any())->willReturn($role);

        $user->addRole($role);

        $this->onUserRegistration($event);
    }
}
