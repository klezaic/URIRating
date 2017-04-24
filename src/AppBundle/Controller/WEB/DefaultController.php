<?php

namespace AppBundle\Controller;

use AppBundle\Entity\URIRating;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
/*
        //izrada novog entiteta
        $URIRating = new URIRating();
        $URIRating->setUri("www.google.com");
        $URIRating->setVisitorId("000abc");
        $URIRating->setRating(9);
        //dodavanje elementa
        $em = $this->getDoctrine()->getManager();
        $em->persist($URIRating);
        $em->flush();
*/
        //Dohvacanje svih entiteta
        $URIRatings = $this->getDoctrine()->getRepository('AppBundle\Entity\URIRating')->findAll();

        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'URIRatingsCount' => strval(count($URIRatings)),

        ));

    }

}
