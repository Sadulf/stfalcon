<?php

namespace StfalconBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageTag
 */
class ImageTag
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $imageId;

    /**
     * @var int
     */
    private $tagId;


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
     * Set imageId
     *
     * @param integer $imageId
     * @return ImageTag
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    /**
     * Get imageId
     *
     * @return integer 
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Set tagId
     *
     * @param integer $tagId
     * @return ImageTag
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * Get tagId
     *
     * @return integer 
     */
    public function getTagId()
    {
        return $this->tagId;
    }
}
