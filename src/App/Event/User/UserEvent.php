<?php

namespace App\Event\User;


use App\Entity\User\User;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event
{
    /**
     * @var \App\Entity\User\User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
