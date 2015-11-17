<?php
/**
 * Created by PhpStorm.
 * User: elli
 * Date: 7/12/2013
 * Time: 10:28 μμ
 */
//src/Viz/DataVizBundle/Entity/ClusterHashtags.php

namespace Viz\DataVizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Viz\DataVizBundle\Entity\Repository\ClusterHashtagsRepository")
 * @ORM\Table(name="cluster_hash")

 */
class ClusterHashtags{
   /** @ORM\Id
    * @ORM\Column(type="bigint")

    */

    protected $nid;
    /**
     * @ORM\Column(type="integer")
     */
    protected $modu;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $t_id;
    /**
     * @ORM\Column(type="text")
     */
    protected $cl_hashtag;

    /**
     * @ORM\ManyToOne(targetEntity="MetaNodes", inversedBy="hashtags")
     * @ORM\JoinColumn(name="modu", referencedColumnName="id")
     */
    protected $metanodes;

    /**
     * Set nid
     *
     * @param integer $nid
     * @return ClusterHashtags
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
     * Set modu
     *
     * @param integer $modu
     * @return ClusterHashtags
     */
    public function setModu($modu)
    {
        $this->modu = $modu;
    
        return $this;
    }

    /**
     * Get modu
     *
     * @return integer 
     */
    public function getModu()
    {
        return $this->modu;
    }

    /**
     * Set t_id
     *
     * @param integer $tId
     * @return ClusterHashtags
     */
    public function setTId($tId)
    {
        $this->t_id = $tId;
    
        return $this;
    }

    /**
     * Get t_id
     *
     * @return integer 
     */
    public function getTId()
    {
        return $this->t_id;
    }

    /**
     * Set cl_hashtag
     *
     * @param string $clHashtag
     * @return ClusterHashtags
     */
    public function setClHashtag($clHashtag)
    {
        $this->cl_hashtag = $clHashtag;
    
        return $this;
    }

    /**
     * Get cl_hashtag
     *
     * @return string 
     */
    public function getClHashtag()
    {
        return $this->cl_hashtag;
    }

    /**
     * Set metanodes
     *
     * @param \Viz\DataVizBundle\Entity\MetaNodes $metanodes
     * @return ClusterHashtags
     */
    public function setMetanodes(\Viz\DataVizBundle\Entity\MetaNodes $metanodes = null)
    {
        $this->metanodes = $metanodes;
    
        return $this;
    }

    /**
     * Get metanodes
     *
     * @return \Viz\DataVizBundle\Entity\MetaNodes 
     */
    public function getMetanodes()
    {
        return $this->metanodes;
    }
}
