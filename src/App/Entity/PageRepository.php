<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class PageRepository extends EntityRepository
{
    /**
     * @param string $query
     * @param array  $whereStatements
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createSearchContentQb($query, $whereStatements = [])
    {
        $rsm = new ResultSetMappingBuilder($this->_em);
        $rsm->addRootEntityFromClassMetadata('App\Entity\Page', 'p');
        $rsm->addJoinedEntityFromClassMetadata('App\Entity\PageTranslation', 'pt', 'p', 'translations', ['id' => 'translatable_id']);
        $rsm->addIndexBy('pt', 'locale');


        $sql = 'SELECT ' . $rsm->generateSelectClause(['p' => 'p', 'pt' => 'pt']) . ' FROM page p ' .
            'INNER JOIN page_translation pt ON pt.translatable_id = p.id ' .
            'WHERE (pt.title LIKE ? OR pt.content LIKE ?) ';

        foreach ($whereStatements as $whereStatement) {
            $sql .= $whereStatement . ' ';
        }

        $sql .= 'ORDER BY CASE ' .
            'WHEN pt.title LIKE ? THEN 0 ' .
            'WHEN pt.title LIKE ? THEN 1 ' .
            'WHEN pt.title LIKE ? THEN 2 ' .
            'ELSE 3 END'
        ;
        $nq = $this->_em->createNativeQuery($sql, $rsm);

        $nq
            ->setParameters([
                1 => '%' . $query . '%',
                2 => '%' . $query . '%',
                3 => $query . ' %',
                4 => '% ' . $query . ' %',
                5 => $query . '%'
            ])
        ;

        return $nq;
    }

    /**
     * Return a query builder of search for a specified language
     *
     * @param string $query
     * @param string $language
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createSearchContentQbForLanguage($query, $language)
    {
        return $this->createSearchContentQb($query, [ ' AND pt.locale = \'' . $language . '\'']);
    }

    /**
     * Return a query builder of search but does not return pages for the specified language
     *
     * @param string $query
     * @param string $language
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createSearchContentQbExceptLanguage($query, $language)
    {
        return $this->createSearchContentQb($query, [' AND pt.locale <> \'' . $language . '\'']);
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
