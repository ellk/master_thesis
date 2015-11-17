<?php

//src/Viz/DataVizBundle/Entity/MetaEdges.php

namespace Viz\DataVizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Viz\DataVizBundle\Entity\Repository\MetaEdgesRepository")
 * @ORM\Table(name="meta_edges")
 * @ORM\HasLifecycleCallbacks()
 */
class MetaEdges{
/** @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
 *
*/
    protected $id;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $source;
    /**
     * @ORM\Column(type="bigint")
     */

    protected $target;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $label;


   


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
     * Set source
     *
     * @param integer $source
     * @return MetaEdges
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
     * @return MetaEdges
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
     * Set label
     *
     * @param string $label
     * @return MetaEdges
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
}