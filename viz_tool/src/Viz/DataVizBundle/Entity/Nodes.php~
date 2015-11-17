<?php

// src/Viz/DataVizBundle/Entity/Nodes.php

namespace Viz\DataVizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="Viz\DataVizBundle\Entity\Repository\NodesRepository")
 * @ORM\Table(name="node_snap")
 * @UniqueEntity("nid")
 * @ORM\HasLifecycleCallbacks()
 */
class Nodes{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     */
  protected $nid;

    /**
     * @ORM\Column(type="integer")
     */
    protected $modu;

    

    /**
     * @ORM\Column(type="float")
     */
    protected $degree;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $label;

    /**
     * @ORM\OneToMany(targetEntity="TweetText", mappedBy="node")
     */
    protected $tweets;
    /**
     * @ORM\OneToMany(targetEntity="Retweets", mappedBy="node")
     */
    protected $rts;





    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tweets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set nid
     *
     * @param integer $nid
     * @return Nodes
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
     * @return Nodes
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
     * Set degree
     *
     * @param float $degree
     * @return Nodes
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    
        return $this;
    }

    /**
     * Get degree
     *
     * @return float 
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return Nodes
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Add tweets
     *
     * @param \Viz\DataVizBundle\Entity\TweetText $tweets
     * @return Nodes
     */
    public function addTweet(\Viz\DataVizBundle\Entity\TweetText $tweets)
    {
        $this->tweets[] = $tweets;
    
        return $this;
    }

    /**
     * Remove tweets
     *
     * @param \Viz\DataVizBundle\Entity\TweetText $tweets
     */
    public function removeTweet(\Viz\DataVizBundle\Entity\TweetText $tweets)
    {
        $this->tweets->removeElement($tweets);
    }

    /**
     * Get tweets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTweets()
    {
        return $this->tweets;
    }

    /**
     * Add rts
     *
     * @param \Viz\DataVizBundle\Entity\Retweets $rts
     * @return Nodes
     */
    public function addRt(\Viz\DataVizBundle\Entity\Retweets $rts)
    {
        $this->rts[] = $rts;
    
        return $this;
    }

    /**
     * Remove rts
     *
     * @param \Viz\DataVizBundle\Entity\Retweets $rts
     */
    public function removeRt(\Viz\DataVizBundle\Entity\Retweets $rts)
    {
        $this->rts->removeElement($rts);
    }

    /**
     * Get rts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRts()
    {
        return $this->rts;
    }
}