<?php
/**
 * Created by PhpStorm.
 * User: klezaic
 * Date: 22.04.17.
 * Time: 22:25
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="uri")
 */
class URIRatingSum
{
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @ORM\Id
     */
    private $uri;

    /**
     * @ORM\Column(type="integer")
     */
    private $sum_rating;

    /**
     * @ORM\Column(type="integer")
     */
    private $sum_users;


    /**
     * Set uri
     *
     * @param string $uri
     * @return URIRatingSum
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
     * Set sum_rating
     *
     * @param integer $sumRating
     * @return URIRatingSum
     */
    public function setSumRating($sumRating)
    {
        $this->sum_rating = $sumRating;

        return $this;
    }

    /**
     * Get sum_rating
     *
     * @return integer 
     */
    public function getSumRating()
    {
        return $this->sum_rating;
    }

    /**
     * Set sum_users
     *
     * @param integer $sumUsers
     * @return URIRatingSum
     */
    public function setSumUsers($sumUsers)
    {
        $this->sum_users = $sumUsers;

        return $this;
    }

    /**
     * Get sum_users
     *
     * @return integer 
     */
    public function getSumUsers()
    {
        return $this->sum_users;
    }
}
