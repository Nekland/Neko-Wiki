<?php

namespace App\Entity;


use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository
{
    /**
     * @param  string $query
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createSearchQb($query)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->where($qb->expr()->like('p.content', ':query'))
            ->setParameter('query', $query)
        ;

        return $qb;
    }
}
