<?php

namespace ECommerceBundle\Repository;

/**
 * ProductRepository
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{

    public function getLastProducts(){
            $query = $this
                ->createQueryBuilder('p')
                ->orderBy('p.id', 'DESC')
                ->setMaxResults(4);

            return $query->getQuery()->getResult();
    }
}
