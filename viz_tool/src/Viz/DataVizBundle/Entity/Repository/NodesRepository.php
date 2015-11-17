<?php

namespace Viz\DataVizBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;



/**
 * NodesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NodesRepository extends EntityRepository
{
    public function getClusterNodes($mod){
        $qb=$this->createQueryBuilder('ns')
           ->select('distinct ns.nid','ns.label','ns.degree')
           ->where('ns.modu=?1')
          ->setParameter(1,$mod);

      $n=  $qb->getQuery()
            ->getResult();


        $mentions=array();
        $retweets=array();
        $attributes=array();
        $nodes=array();
        foreach($n as $node){
            $attributes['degree']=$node['degree'];
            $m= $this->getEntityManager()->getRepository('VizDataVizBundle:TweetText')
                ->getTweetText($node['nid']);
            $rt= $this->getEntityManager()->getRepository('VizDataVizBundle:Retweets')
                ->getRetweets($node['nid']);

            foreach($m as $mention){
                $mentions[]=$mention['tweet_text'];
            }
            $attributes['mentions']=$mentions;
            if($rt!=null){
            foreach($rt as $rtw){
                $retweets['rtw_id']=$rtw['rtw_id'];
                $retweets['rtw']=$rtw['retweets'];

            }

            }
            else{
                $retweets=null;
            }
            $attributes['retweets']=[$retweets];
            $nodes[]=array("id"=>$node['nid'],"label"=>$node['label'],"attributes"=>[$attributes]);
            $mentions=array();
            $retweets=array();

        }
        return $nodes;
    }
    public function getNodesByHashtag(array $h){

        $sb = $this->getEntityManager()->getRepository('VizDataVizBundle:TweetText')
            ->getUserId($h);

        $qb=$this->createQueryBuilder('ns')
            ->select('distinct ns.nid','ns.label','ns.degree','ns.modu')
            ->where('ns.nid In (:nodes)')
            ->setParameter('nodes',$sb);

        $htn= $qb->getQuery()
            ->getResult();

        $mentions=array(); // edw to eixa ws array
        $attributes=array();
        $nodes=array();
        $retweets=array();
        foreach($htn as $node){

            $attributes['degree']=$node['degree'];
            $m= $this->getEntityManager()->getRepository('VizDataVizBundle:TweetText')
                ->getTweetText($node['nid']);
            $rt= $this->getEntityManager()->getRepository('VizDataVizBundle:Retweets')
                ->getRetweets($node['nid']);
            foreach($m as $mention){
                $mentions[]=$mention['tweet_text'];
            }
            $attributes['mentions']=$mentions;
            if($rt!=null){
                foreach($rt as $rtw){
                    $retweets['rtw_id']=$rtw['rtw_id'];
                    $retweets['rtw']=$rtw['retweets'];

                }

            }
            else{
                $retweets=null;
            }
            $attributes['retweets']=[$retweets];
            $mentions=array();
            $nodes[]=array("id"=>$node['nid'],"label"=>$node['label'],"attributes"=>[$attributes]);
        }
      return $nodes;
    }
}
