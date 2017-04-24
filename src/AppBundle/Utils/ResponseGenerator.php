<?php
/**
 * Created by PhpStorm.
 * User: klezaic
 * Date: 23.04.17.
 * Time: 17:11
 */

namespace AppBundle\Utils;


use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseGenerator
 * @package AppBundle\Utils
 */
class ResponseGenerator
{
    /**
     * @param $serializedObject
     * @return Response
     */
    public static function generateSuccessfulJSONResponse($serializedObject)
    {
        $response = new Response(
            $serializedObject,
            Response::HTTP_CREATED,
            array(
                'content-type' => 'application/json',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
                'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            )
        );

        return $response;
    }

    /**
     * @param $serializedObject
     * @return Response
     */
    public static function generateSuccessfulJSONURIResponse($serializedObject)
    {
        $response = new Response(
            $serializedObject,
            Response::HTTP_OK,
            array(
                'content-type' => 'application/json',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
                'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            )
        );

        return $response;
    }

    /**
     * @param $serializedObject
     * @return Response
     */
    public static function generateFailureJSONResponse($serializedObject)
    {
        $response = new Response(
            $serializedObject,
            Response::HTTP_BAD_REQUEST,
            array(
                'content-type' => 'application/json',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
                'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            )
        );

        return $response;
    }

    /**
     * @param $message
     * @return Response
     */
    public static function generateMalformedJSONResponse($message)
    {
        $response = new Response(
            json_encode(array('error' => $message)),
            Response::HTTP_BAD_REQUEST,
            array(
                'content-type' => 'application/json',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
                'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            )
        );

        return $response;
    }


}