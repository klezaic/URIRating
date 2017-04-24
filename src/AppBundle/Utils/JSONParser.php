<?php
/**
 * Created by PhpStorm.
 * User: klezaic
 * Date: 23.04.17.
 * Time: 00:43
 */

namespace AppBundle\Utils;


use AppBundle\Entity\URIRating;
use AppBundle\Entity\URIRatingResponse;
use AppBundle\Entity\URIRatingSum;
use AppBundle\Entity\URIScoreResponse;
use Symfony\Component\Debug\Exception\ContextErrorException;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Class JSONParser
 * @package AppBundle\Utils
 */
class JSONParser
{
    /**
     * @param $string
     * @return URIRating
     */
    public static function saveURIRating($string)
    {
        $object = json_decode($string);

        if (json_last_error() == JSON_ERROR_NONE) {
            try {
                $visitor_id = $object->{'visitor_id'};
                $uri = $object->{'uri'};
                $rating = $object->{'rating'};
            } catch (ContextErrorException $exception) {
                $msg = explode("$", $exception->getMessage());
                throw new Exception('JSON field '.end($msg).' is missing!');
            }

            $URIRating = new URIRating();
            $URIRating->setVisitorId($visitor_id);
            $URIRating->setUri($uri);
            $URIRating->setRating($rating);

            return $URIRating;
        } else {
            throw new Exception('Not valid JSON');
        }
    }


    /**
     * @param $string
     * @return mixed
     */
    public static function parseURI($string)
    {
        $object = json_decode($string);

        if (json_last_error() == JSON_ERROR_NONE) {
            try {
                $uri = $object->{'uri'};

                return $uri;
            } catch (ContextErrorException $exception) {
                $msg = explode("$", $exception->getMessage());
                throw new Exception('JSON field '.end($msg).' is missing!');
            }
        } else {
            throw new Exception('Not valid JSON');
        }
    }


    /**
     * @param $status
     * @param URIRatingSum $object
     * @param $score
     * @return string
     */
    public static function getURIScoreResponse($status, URIRatingSum $object, $score)
    {
        $response = new URIScoreResponse();
        $response->setUri($object->getUri());
        $response->setScore($score);
        $response->setStatus($status);

        $json_response = json_encode($response);

        return $json_response;
    }


    /**
     * @param $status
     * @param URIRating $object
     * @param $score
     * @return string
     */
    public static function getURIRatingResponse($status, URIRating $object, $score)
    {
        $response = new URIRatingResponse();
        $response->setStatus($status);
        $response->setUri($object->getUri());
        $response->setRating($object->getRating());
        $response->setScore($score);

        $json_response = json_encode($response);

        return $json_response;
    }
}