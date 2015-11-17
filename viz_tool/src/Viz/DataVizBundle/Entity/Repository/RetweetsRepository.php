<?php

namespace Viz\DataVizBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * RetweetsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RetweetsRepository extends EntityRepository
{
    public function getRetweets($id){
        $qb=$this->createQueryBuilder('rtws')
            ->select('distinct rtws.rtw_id','rtws.retweets')
            ->where('rtws.nid = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()
            ->getResult();


    }

}