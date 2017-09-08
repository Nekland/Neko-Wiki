<?php

namespace App\Search\ElasticSearch\Listeners;


use App\Entity\PageTranslation;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class RegisterPageTranslation
 *
 * Update elasticsearch with new page translation content.
 */
class RegisterPageTranslation implements EventSubscriber
{
    public function postUpdate(LifecycleEventArgs $event)
    {

    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof PageTranslation) {
            // TODO: save inside elasticSearch
            var_dump('TODO: saving inside elasticsearch. ' . $entity->getId());
            //exit;
        }
    }

    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
        );
    }
}
