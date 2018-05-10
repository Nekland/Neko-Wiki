<?php

namespace Nekland\NekoWiki\Infrastructure\Controller;

use Nekland\NekoWiki\Exception\WikiNotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

/**
 * Simple enhanced controller
 */
class Controller extends BaseController
{
    /**
     * Set a flash and automatically translate the message
     *
     * @param $name
     * @param $message
     */
    protected function setFlash($name, $message)
    {
        $this->getSession()
            ->getFlashBag()
            ->add(
                $name,
                $this->getTranslator()->trans($message)
            )
        ;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    protected function getSession()
    {
        return $this->get('session');
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected function getTranslator()
    {
        return $this->get('translator');
    }

    /**
     * @param $entity
     */
    protected function persistAndFlush($entity)
    {
        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush($entity);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function getForm()
    {
        return $this->createForm('neko_wiki_search', null, [
            'action' => $this->generateUrl('search'),
            'method' => 'POST'
        ]);
    }

    /**
     * @return string
     */
    public function getCurrentLocale()
    {
        return $this->get('neko_wiki.language.manager')->getCurrentLanguage();
    }
}
