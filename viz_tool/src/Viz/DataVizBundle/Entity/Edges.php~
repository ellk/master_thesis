<?php

//src/Viz/DataVizBundle/Entity/Edges.php

namespace Viz\DataVizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Viz\DataVizBundle\Entity\Repository\EdgesRepository")
 * @ORM\Table(name="edge_snap")
 * @ORM\HasLifecycleCallbacks()
 */
class Edges{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */


    protected $id;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $tw_id;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $rtw_id;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $source;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $target;
    /**
     * @ORM\Column(type="integer")
     */
    protected $weight;
    /**
     * @ORM\Column(type="string")
     */
    protected $label;
    /**
     * @ORM\Column(type="integer")
     */
    protected $modu;
    /**
     * @ORM\Column(type="text")
     */
    protected $timesta;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $retweetCount;








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
     * Set tw_id
     *
     * @param integer $twId
     * @return Edges
     */
    public function setTwId($twId)
    {
        $this->tw_id = $twId;
    
        return $this;
    }

    /**
     * Get tw_id
     *
     * @return integer 
     */
    public function getTwId()
    {
        return $this->tw_id;
    }

    /**
     * Set rtw_id
     *
     * @param integer $rtwId
     * @return Edges
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
     * Set source
     *
     * @param integer $source
     * @return Edges
     */
    public function setSource($source)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get source
     *
     * @return integer 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set target
     *
     * @param integer $target
     * @return Edges
     */
    public function setTarget($target)
    {
        $this->target = $target;
    
        return $this;
    }

    /**
     * Get target
     *
     * @return integer 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Edges
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    
        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return Edges
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
     * Set modu
     *
     * @param integer $modu
     * @return Edges
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
     * Set timesta
     *
     * @param string $timesta
     * @return Edges
     */
    public function setTimesta($timesta)
    {
        $this->timesta = $timesta;
    
        return $this;
    }

    /**
     * Get timesta
     *
     * @return string 
     */
    public function getTimesta()
    {
        return $this->timesta;
    }

    /**
     * Set retweetCount
     *
     * @param integer $retweetCount
     * @return Edges
     */
    public function setRetweetCount($retweetCount)
    {
        $this->retweetCount = $retweetCount;
    
        return $this;
    }

    /**
     * Get retweetCount
     *
     * @return integer 
     */
    public function getRetweetCount()
    {
        return $this->retweetCount;
    }
}