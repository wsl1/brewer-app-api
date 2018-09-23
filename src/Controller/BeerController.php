<?php

namespace App\Controller;

use App\Entity\Beer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeerController extends Controller
{
    /**
     * @Route("/beers")
     */
    public function getBeers()
    {
        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $beerRepository->findAll();

        $response = $serializer->serialize($beers, 'json');
        return new Response($response);
    }

    /**
     * @Route("/beers/{name}")
     */
    public function getBeersByName(string $name) {
        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $beerRepository->findByName($name);

        $response = $serializer->serialize($beers, 'json');
        return new Response($response);
    }

    /**
     * @Route("/beers/{from}/{to}")
     */
    public function getBeersByPriceRange(float $from, float $to) {
        $serializer = $this->get('jms_serializer');

        $from = $from * 100;
        $to = $to * 100;

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $beerRepository->findByPriceRange($from, $to);

        $response = $serializer->serialize($beers, 'json');
        return new Response($response);
    }
}
