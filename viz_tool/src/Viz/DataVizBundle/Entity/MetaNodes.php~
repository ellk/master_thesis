<?php

//src/Viz/DataVizBundle/Entity/MetaNodes.php

namespace Viz\DataVizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Viz\DataVizBundle\Entity\Repository\MetaNodesRepository")
 * @ORM\Table(name="communities")
 * @ORM\HasLifecycleCallbacks()
 */
class MetaNodes{

/** @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
*/
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $num_nodes;

    /**
     * @ORM\Column(type="integer")
     */
    protected $num_edges;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $density;

    /**
     * @ORM\OneToMany(targetEntity="ClusterHashtags", mappedBy="metanodes")
     */
    protected $hashtags;






    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hashtags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set num_nodes
     *
     * @param integer $numNodes
     * @return MetaNodes
     */
    public function setNumNodes($numNodes)
    {
        $this->num_nodes = $numNodes;
    
        return $this;
    }

    /**
     * Get num_nodes
     *
     * @return integer 
     */
    public function getNumNodes()
    {
        return $this->num_nodes;
    }

    /**
     * Set num_edges
     *
     * @param integer $numEdges
     * @return MetaNodes
     */
    public function setNumEdges($numEdges)
    {
        $this->num_edges = $numEdges;
    
        return $this;
    }

    /**
     * Get num_edges
     *
     * @return integer 
     */
    public function getNumEdges()
    {
        return $this->num_edges;
    }

    /**
     * Set density
     *
     * @param float $density
     * @return MetaNodes
     */
    public function setDensity($density)
    {
        $this->density = $density;
    
        return $this;
    }

    /**
     * Get density
     *
     * @return float 
     */
    public function getDensity()
    {
        return $this->density;
    }

    /**
     * Add hashtags
     *
     * @param \Viz\DataVizBundle\Entity\ClusterHashtags $hashtags
     * @return MetaNodes
     */
    public function addHashtag(\Viz\DataVizBundle\Entity\ClusterHashtags $hashtags)
    {
        $this->hashtags[] = $hashtags;
    
        return $this;
    }

    /**
     * Remove hashtags
     *
     * @param \Viz\DataVizBundle\Entity\ClusterHashtags $hashtags
     */
    public function removeHashtag(\Viz\DataVizBundle\Entity\ClusterHashtags $hashtags)
    {
        $this->hashtags->removeElement($hashtags);
    }

    /**
     * Get hashtags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }
}