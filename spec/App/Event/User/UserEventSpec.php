<?php


namespace spec\App\Event\User;


use PhpSpec\ObjectBehavior;

class UserEventSpec extends ObjectBehavior
{
    /**
     * @param \App\Entity\User\User $user
     */
    public function let($user)
    {
        $this->beConstructedWith($user);
    }

    public function it_should_return_the_user($user)
    {
        $this->getUser()->shouldReturn($user);
    }
} 