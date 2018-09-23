<?php

namespace App\Controller;

use App\Entity\Brewer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class BrewerController extends Controller
{
    /**
     * @Route("/brewers")
     */
    public function getBrewers() {
        $serializer = $this->get('jms_serializer');

        $brewerRepository = $this->getDoctrine()->getRepository(Brewer::class);
        try {
            $brewers = $brewerRepository->findAllBrewers();
            if(!count($brewers)) {
                return new JsonResponse(['message' => 'Could not find any brewer'], 404);
            }
            $response = $serializer->serialize($brewers, 'json');
            return new Response($response);

        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An error occured'], 500);
        }
    }

    /**
     * @Route("/brewers/{id}", name="brewers", requirements={"id"="\d+"})
     */
    public function getBrewerById($id)
    {
        $serializer = $this->get('jms_serializer');

        $brewerRepository = $this->getDoctrine()->getRepository(Brewer::class);
        try {
            $brewer = $brewerRepository->find($id);
            if(!count($brewer)) {
                return new JsonResponse(['message' => 'Could not find any brewer'], 404);
            }
            $response = $serializer->serialize($brewer, 'json');
            return new Response($response);

        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An error occured'], 500);
        }
    }
}
