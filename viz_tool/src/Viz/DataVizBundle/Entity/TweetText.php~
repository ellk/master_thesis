<?php
//src/Viz/DataVizBundle/Repository/TweetText.php

namespace Viz\DataVizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;/**
 *
 * @ORM\Entity(repositoryClass="Viz\DataVizBundle\Entity\Repository\TweetTextRepository")
 * @ORM\Table(name="tweets_texts",options={"collate"="utf8", "charset"="utf8"})
 * @ORM\HasLifecycleCallbacks()
 */
class TweetText{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)

     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;
    /**
     * @ORM\Column(type="integer")
     */
    protected $modu;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $tweet_id;

    /**
     * @ORM\Column(type="text")
     */
    protected $tweet_text;
    /**
     * @ORM\Column(type="bigint")
     */
    protected $usr_id;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $timesta;
    /**
     * @ORM\ManyToOne(targetEntity="Nodes", inversedBy="tweets")
     * @ORM\JoinColumn(name="usr_id", referencedColumnName="nid")
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
     * Set modu
     *
     * @param integer $modu
     * @return TweetText
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
     * Set tweet_id
     *
     * @param integer $tweetId
     * @return TweetText
     */
    public function setTweetId($tweetId)
    {
        $this->tweet_id = $tweetId;
    
        return $this;
    }

    /**
     * Get tweet_id
     *
     * @return integer 
     */
    public function getTweetId()
    {
        return $this->tweet_id;
    }

    /**
     * Set tweet_text
     *
     * @param string $tweetText
     * @return TweetText
     */
    public function setTweetText($tweetText)
    {
        $this->tweet_text = $tweetText;
    
        return $this;
    }

    /**
     * Get tweet_text
     *
     * @return string 
     */
    public function getTweetText()
    {
        return $this->tweet_text;
    }

    /**
     * Set usr_id
     *
     * @param integer $usrId
     * @return TweetText
     */
    public function setUsrId($usrId)
    {
        $this->usr_id = $usrId;
    
        return $this;
    }

    /**
     * Get usr_id
     *
     * @return integer 
     */
    public function getUsrId()
    {
        return $this->usr_id;
    }

    /**
     * Set timesta
     *
     * @param \DateTime $timesta
     * @return TweetText
     */
    public function setTimesta($timesta)
    {
        $this->timesta = $timesta;
    
        return $this;
    }

    /**
     * Get timesta
     *
     * @return \DateTime 
     */
    public function getTimesta()
    {
        return $this->timesta;
    }

    /**
     * Set node
     *
     * @param \Viz\DataVizBundle\Entity\Nodes $node
     * @return TweetText
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