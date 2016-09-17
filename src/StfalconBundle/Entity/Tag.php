<?php

namespace StfalconBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 */
class Tag
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $tag;


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
     * Set tag
     *
     * @param string $tag
     * @return Tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
