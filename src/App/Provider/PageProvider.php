<?php

namespace App\Provider;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageProvider
{
    private $em;

    /**
     * @param EntityManager $em
     * @param string        $defaultLanguage
     */
    public function __construct(EntityManager $em, $defaultLanguage = 'en')
    {
        $this->em              = $em;
        $this->defaultLanguage = $defaultLanguage;
    }

    /**
     * @return \App\Entity\Page
     * @throws NotFoundHttpException
     */
    public function getHomepage()
    {
        $page = $this->findPageBySlug('home');

        if ($page === null) {
            throw new NotFoundHttpException('The homepage is not findable. Please read the documentation of NekoWiki about installation.');
        }

        return $page;
    }

    /**
     * @param string $slug
     * @return null|\App\Entity\Page
     */
    public function findPageBySlug($slug)
    {
        $translation = $this->getTranslationRepository()->findOneBy(['titleSlug' => $slug]);
        if ($translation === null) {
            return null;
        }

        return $translation->getTranslatable();
    }

    /**
     * @param string $title
     * @return null|\App\Entity\Page
     */
    public function findPageByTitle($title)
    {
        $translation = $this->getTranslationRepository()->findOneBy(['title' => $title]);
        if ($translation === null) {
            return null;
        }

        return $translation->getTranslatable();
    }

    /**
     * @param $title
     * @return null|\App\Entity\Page
     */
    public function searchPage($title)
    {
        return $this->findPageByTitle($title);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getTranslationRepository()
    {
        return $this->em->getRepository('NekoWiki:PageTranslation');
    }
}
