<?php

namespace App\Controller;

use App\Entity\Beer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use League\ISO3166\ISO3166;

class BeerController extends Controller
{
    /**
     * @Route("/beers")
     */
    public function getBeers() {
        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $beerRepository->findAll();

        $response = $serializer->serialize($beers, 'json');
        return new Response($response);
    }

    /**
     * @Route("/beers/name/{name}")
     */
    public function getBeersByName(string $name) {
        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $beerRepository->findByName($name);

        $response = $serializer->serialize($beers, 'json');
        return new Response($response);
    }

    /**
     * @Route("/beers/price/{from}/{to}")
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

    /**
     * @Route("/beers/countries")
     */
    public function getCountries() {
        $serializer = $this->get('jms_serializer');
        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        $countries = $beerRepository->findCountries();

        //$response = $serializer->serialize($countries, 'json');
        return new JsonResponse($countries);
    }

    /**
     * @Route("/beers/countries/{countryCode}", requirements={"countryCode"="[a-zA-Z]{2}"})
     */
    public function getBeersByCountryCode(string $countryCode) {
        $serializer = $this->get('jms_serializer');
        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $beerRepository->findByCountryCode($countryCode);

        $response = $serializer->serialize($beers, 'json');
        return new Response($response);
    }

    /**
     * @Route("/beers/types/{type}")
     */
    public function getBeersByType(string $type) {
        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $beerRepository->findByType($type);

        $response = $serializer->serialize($beers, 'json');
        return new Response($response);
    }

    /**
     * @Route("/beers/all")
     */
    public function getBeersByAll(Request $request){
        $name = $request->query->get('name') ? $request->query->get('name') : null;
        $from = $request->query->get('from') ? $request->query->get('from') : null;
        $to = $request->query->get('to') ? $request->query->get('to') : null;
        $country = $request->query->get('country') ? $request->query->get('country') : null;
        $type = $request->query->get('type') ? $request->query->get('type') : null;
        $brewerName = $request->query->get('brewerName') ? $request->query->get('brewerName') : null;

        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $beerRepository->findByAll($name, $from, $to, $country, $type, $brewerName);

        $response = $serializer->serialize($beers, 'json');
        return new Response($response);
    }
}
