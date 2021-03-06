<?php

namespace Viz\DataVizBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ClusterHashtagsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClusterHashtagsRepository extends EntityRepository
{

    public function getClHashtags($modu){

        $qb = $this->createQueryBuilder('ch')
            ->select('ch.cl_hashtag')
            ->where('ch.modu = :mod')
            ->setParameter('mod', $modu);



        return $qb->getQuery()
            ->getResult();
    }

    public function getTweetIDs($h){

        $qb = $this->createQueryBuilder('ch')
            ->select('ch.t_id')
            ->where('ch.cl_hashtag = :clh')
            ->setParameter('clh', $h);



        return $qb->getQuery()
            ->getResult();


    }
    public function getHashtags(){
        $qb = $this->createQueryBuilder('ch')
            ->select('distinct ch.cl_hashtag');


       $ht= $qb->getQuery()
            ->getResult();
        $hashtags=array();
        foreach($ht as $hash){
            $hashtags[]=$hash['cl_hashtag'];
        }

        return $hashtags;

    }

    public function getVisualizationByHashtag( $array){

        $sb1 = $this->getEntityManager()->getRepository('VizDataVizBundle:Nodes')
            ->getNodesByHashtag($array);



        $sb2= $this->getEntityManager()->getRepository('VizDataVizBundle:Edges')
            ->getEdgesByHashtag($array);




        return array('nodes'=>$sb1,'edges'=>$sb2);





    }


}
