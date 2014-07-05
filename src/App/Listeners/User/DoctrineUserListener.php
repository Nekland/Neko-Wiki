<?php

namespace App\Listeners\User;


use App\Entity\User\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class DoctrineUserListener
{
    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * Encode the password if it change
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // We will only work on User entities
        if ($entity instanceof User) {

            $em         = $args->getEntityManager();
            $unitOfWork = $em->getUnitOfWork();

            $changeSet  = $unitOfWork->getEntityChangeSet($entity);

            // If the password was changed we have to encode it
            if (array_key_exists('password', $changeSet)) {
                $password = $this->encoderFactory
                    ->getEncoder($entity)
                    ->encodePassword($entity->getPassword(), $entity->getSalt())
                ;
                $entity->setPassword($password);

                // Register the password modification
                $unitOfWork->computeChangeSet($em->getClassMetadata(get_class($entity)), $entity);
            }
        }
    }
}
