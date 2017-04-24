<?php
/**
 * Created by PhpStorm.
 * User: klezaic
 * Date: 22.04.17.
 * Time: 23:44
 */

namespace AppBundle\Controller\API;

use AppBundle\Entity\URIRatingSum;
use AppBundle\Utils\JSONParser;
use AppBundle\Utils\ResponseGenerator;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Exception\Exception;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Class RatingsController
 * @package AppBundle\Controller\API
 */
class RatingsController extends Controller
{
    /**
     * @Route("/api/setRating")
     * @Method("POST")
     *
     */
    public function setURIRating(Request $request)
    {
        $body = $request->getContent();
        try {
            $URIRating = JSONParser::saveURIRating($body);

            //JSON 'uri' in 0-10
            if ($URIRating->getRating() >= 0 && $URIRating->getRating() <= 10) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($URIRating);
                $em->flush();

                $URIRatingSumFetched = $this->getDoctrine()
                    ->getRepository('AppBundle\Entity\URIRatingSum')
                    ->findOneBy(array('uri' => $URIRating->getUri()));
                /* @var $URIRatingSumFetched URIRatingSum */

                //Is there data for requested 'uri'
                if (!$URIRatingSumFetched) {
                    $em = $this->getDoctrine()->getManager();

                    $URIRatingSum = new URIRatingSum();
                    $URIRatingSum->setUri($URIRating->getUri());
                    $URIRatingSum->setSumRating($URIRating->getRating());
                    $URIRatingSum->setSumUsers(1);

                    $em->persist($URIRatingSum);
                    $em->flush();
                } else {
                    $em = $this->getDoctrine()->getManager();

                    $newSumRating = $URIRatingSumFetched->getSumRating() + $URIRating->getRating();
                    $newSumUsers = $URIRatingSumFetched->getSumUsers() + 1;
                    $URIRatingSumFetched->setSumRating($newSumRating);
                    $URIRatingSumFetched->setSumUsers($newSumUsers);

                    $em->flush();
                }
            } else {
                $URIRatingsSum = $this->getDoctrine()
                    ->getRepository('AppBundle\Entity\URIRatingSum')
                    ->findOneBy(array('uri' => $URIRating->getUri()));
                /* @var $URIRatingsSum URIRatingSum */

                //Is there data for requested 'uri'
                if (!$URIRatingsSum) {
                    $responseObject = JSONParser::getURIRatingResponse('failure', $URIRating, 0);

                    return ResponseGenerator::generateFailureJSONResponse($responseObject);
                } else {
                    $average = $URIRatingsSum->getSumRating() / $URIRatingsSum->getSumUsers();
                    $responseObject = JSONParser::getURIRatingResponse('failure', $URIRating, $average);

                    return ResponseGenerator::generateFailureJSONResponse($responseObject);
                }
            }
        } //Exception thrown due to 'visitor_id' or 'uri' exceeding 255 characters
        catch (DriverException $exception) {
            $URIRatingsSum = $this->getDoctrine()
                ->getRepository('AppBundle\Entity\URIRatingSum')
                ->findOneBy(array('uri' => $URIRating->getUri()));
            /* @var $URIRatingsSum URIRatingSum */

            if (!$URIRatingsSum) {
                $average = 0;
            } else {
                $average = $URIRatingsSum->getSumRating() / $URIRatingsSum->getSumUsers();
            }

            $responseObject = JSONParser::getURIRatingResponse('failure', $URIRating, $average);

            return ResponseGenerator::generateFailureJSONResponse($responseObject);
        } //Exception thrown by JSONParser due to malformed JSON
        catch (Exception $exception) {
            return ResponseGenerator::generateMalformedJSONResponse($exception->getMessage());
        }

        $URIRatingsSum = $this->getDoctrine()
            ->getRepository('AppBundle\Entity\URIRatingSum')
            ->findOneBy(array('uri' => $URIRating->getUri()));
        /* @var $URIRatingsSum URIRatingSum */

        $average = $URIRatingsSum->getSumRating() / $URIRatingsSum->getSumUsers();

        $responseObject = JSONParser::getURIRatingResponse('success', $URIRating, $average);

        return ResponseGenerator::generateSuccessfulJSONResponse($responseObject);
    }

    /**
     * @Route("/api/getAvgRating/{uri}")
     * @Method("GET")
     *
     */
    public function getURIRatingAVG($uri)
    {
        $URIRatingsSumFetched = $this->getDoctrine()
            ->getRepository('AppBundle\Entity\URIRatingSum')
            ->findOneBy(array('uri' => $uri));
        /* @var $URIRatingsSumFetched URIRatingSum */

        //Is there data for requested 'uri'
        if (!$URIRatingsSumFetched) {
            $URIRatingsSumFetched = new URIRatingSum();
            $URIRatingsSumFetched->setUri($uri);

            $responseObject = JSONParser::getURIScoreResponse('failure', $URIRatingsSumFetched, 0);

            return ResponseGenerator::generateFailureJSONResponse($responseObject);
        } else {
            $score = $URIRatingsSumFetched->getSumRating() / $URIRatingsSumFetched->getSumUsers();
            $responseObject = JSONParser::getURIScoreResponse('success', $URIRatingsSumFetched, $score);

            return ResponseGenerator::generateSuccessfulJSONURIResponse($responseObject);
        }
    }
}