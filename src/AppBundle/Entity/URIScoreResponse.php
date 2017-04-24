<?php
/**
 * Created by PhpStorm.
 * User: klezaic
 * Date: 23.04.17.
 * Time: 19:06
 */

namespace AppBundle\Entity;

use JsonSerializable;

class URIScoreResponse implements JsonSerializable
{
    private $status;
    private $uri;
    private $score;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }


}