<?php

/**
 * Created by PhpStorm.
 * User: klezaic
 * Date: 22.04.17.
 * Time: 21:37
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="uri_rating")
 */
class URIRating
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $visitor_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $uri;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;


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
     * Set visitor_id
     *
     * @param string $visitorId
     * @return URIRating
     */
    public function setVisitorId($visitorId)
    {
        $this->visitor_id = $visitorId;

        return $this;
    }

    /**
     * Get visitor_id
     *
     * @return string 
     */
    public function getVisitorId()
    {
        return $this->visitor_id;
    }

    /**
     * Set uri
     *
     * @param string $uri
     * @return URIRating
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string 
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     * @return URIRating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }
}
