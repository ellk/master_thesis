<?php
/**
 * Created by PhpStorm.
 * User: elli
 * Date: 14/2/2014
 * Time: 2:58 μμ
 */

//src/Viz/DataVizBundle/Repository/Retweets.php

namespace Viz\DataVizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 *
 * @ORM\Entity(repositoryClass="Viz\DataVizBundle\Entity\Repository\RetweetsRepository")
 * @ORM\Table(name="retweets",options={"collate"="utf8mb4", "charset"="utf8mb4"})
 * @UniqueEntity({"nid", "rtw_id"})
 * @ORM\HasLifecycleCallbacks()
 */

class Retweets{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $nid;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $rtw_id;
    /**
     * @ORM\Column(type="integer")
     */
    protected $retweets;
    /**
     * @ORM\ManyToOne(targetEntity="Nodes", inversedBy="rts")
     * @ORM\JoinColumn(name="nid", referencedColumnName="nid")
     */
    protected $node;






    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nid
     *
     * @param integer $nid
     * @return Retweets
     */
    public function setNid($nid)
    {
        $this->nid = $nid;
    
        return $this;
    }

    /**
     * Get nid
     *
     * @return integer 
     */
    public function getNid()
    {
        return $this->nid;
    }

    /**
     * Set rtw_id
     *
     * @param integer $rtwId
     * @return Retweets
     */
    public function setRtwId($rtwId)
    {
        $this->rtw_id = $rtwId;
    
        return $this;
    }

    /**
     * Get rtw_id
     *
     * @return integer 
     */
    public function getRtwId()
    {
        return $this->rtw_id;
    }

    /**
     * Set retweets
     *
     * @param integer $retweets
     * @return Retweets
     */
    public function setRetweets($retweets)
    {
        $this->retweets = $retweets;
    
        return $this;
    }

    /**
     * Get retweets
     *
     * @return integer 
     */
    public function getRetweets()
    {
        return $this->retweets;
    }

    /**
     * Set node
     *
     * @param \Viz\DataVizBundle\Entity\Nodes $node
     * @return Retweets
     */
    public function setNode(\Viz\DataVizBundle\Entity\Nodes $node = null)
    {
        $this->node = $node;
    
        return $this;
    }

    /**
     * Get node
     *
     * @return \Viz\DataVizBundle\Entity\Nodes 
     */
    public function getNode()
    {
        return $this->node;
    }
}