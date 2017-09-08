<?php

namespace App\Entity;


use Doctrine\ORM\EntityRepository;

class PageTranslationRepository extends EntityRepository
{
    public function createElasticSearchQueryBuilder($alias)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('p', $alias)
            ->from('NekoWiki:Page', 'p')
            ->innerJoin('p.translations', $alias)
        ;

        return $qb;
    }
}
