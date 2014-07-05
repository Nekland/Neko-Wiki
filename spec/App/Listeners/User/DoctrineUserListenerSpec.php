<?php

namespace spec\App\Listeners\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DoctrineUserListenerSpec extends ObjectBehavior
{
    /**
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface  $encoderFactory
     * @param \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface $encoder
     */
    function let($encoderFactory, $encoder)
    {
        $this->beConstructedWith($encoderFactory);
        $encoderFactory->getEncoder(Argument::any())->willReturn($encoder);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     * @param \Doctrine\ORM\EntityManagerInterface   $em
     * @param \Doctrine\ORM\UnitOfWork               $unitOfWork
     * @param \App\Entity\User\User                  $user
     * @param \Doctrine\ORM\Mapping\ClassMetadata    $metadata
     */
    function it_should_set_encoded_password_into_user($event, $em, $unitOfWork, $user, $metadata, $encoder)
    {
        $event->getEntityManager()->willReturn($em);
        $event->getEntity()->willReturn($user);

        $em->getUnitOfWork(Argument::any())->willReturn($unitOfWork);
        $em->getClassMetadata(Argument::any())->willReturn($metadata);

        $unitOfWork->getEntityChangeSet(Argument::any())->willReturn(['password' => ['change_set']]);
        $unitOfWork->computeChangeSet($metadata, $user)->shouldBeCalled();

        $encoder->encodePassword('something', 'a_salt')->willReturn('encoded_password');

        $user->getPassword()->willReturn('something')->shouldBeCalled();
        $user->getSalt()->willReturn('a_salt')->shouldBeCalled();
        $user->setPassword('encoded_password')->shouldBeCalled();

        $this->postPersist($event);
    }
}
