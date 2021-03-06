<?php

namespace Viz\DataVizBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TweetTextRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TweetTextRepository extends EntityRepository
{

    public function getTweetText($id){

        $qb=$this->createQueryBuilder('tw')
            ->select('distinct tw.tweet_text')
            ->where('tw.usr_id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()
            ->getResult();


    }

    public function getUserId(array $hashtag){


        $array=array();

        for ($i=0;$i<sizeof($hashtag);$i++){

            $sb= $this->getEntityManager()->getRepository('VizDataVizBundle:ClusterHashtags')
                ->getTweetIDs($hashtag[$i]);

            foreach($sb as $q){
                $qb=$this->createQueryBuilder('tw')
                ->select('distinct tw.usr_id')
                ->where('tw.tweet_id = :param')
                ->setParameter('param', $q['t_id']);






            $r=$qb->getQuery()
                ->getResult();
            foreach($r as $rs){
            array_push($array,$rs['usr_id']);
                }
            }

        }

        return $array;
    }
}
