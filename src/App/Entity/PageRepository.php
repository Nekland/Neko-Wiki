<?php

namespace App\Entity;


use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository
{
    /**
     * @param  string $query
     * @param  string $locale
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createSearchContentQb($query, $locale='en')
    {
        $qb = $this->createQueryBuilder('p');

        $qb->innerJoin('p.translations', 'pt');

        $qb
            ->where($qb->expr()->like('pt.content', ':query'))
            ->andWhere($qb->expr()->eq('pt.locale', ':locale'))
            ->setParameter('query', '%' . $query . '%')
            ->setParameter('locale', $locale)
        ;

        return $qb;
    }

    /**
     * @param  string $query
     * @return Page[]
     */
    public function createSearchTitle($query)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->where($qb->expr()->like('p.content', ':query'))
            ->setParameter('query', '%' . $query . '%')
        ;

        return $qb->getQuery()->execute();
    }

    /**
     * @param  string $slug
     * @return Page|null
     */
    public function findBySlug($slug)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where($qb->expr()->eq('p.titleSlug', ':slug'))
            ->setParameter('slug', $slug)
        ;

        $pages = $qb->getQuery()->execute();

        if (empty($pages)) {
            $pages = null;
        } else {
            $pages = $pages[0];
        }

        return $pages;
    }
}
