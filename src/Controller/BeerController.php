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
        try {
            $beers = $beerRepository->findAll();
            if(!count($beers)) {
                return new JsonResponse(['message' => 'Could not find any beer'], 404);
            }
            $response = $serializer->serialize($beers, 'json');
            return new Response($response);

        } catch (\Exception $e){
            return new JsonResponse(['message' => 'An error occured'], 500);
        }


    }

    /**
     * @Route("/beers/name/{name}")
     */
    public function getBeersByName(string $name) {
        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        try {
            $beers = $beerRepository->findByName($name);
            if(!count($beers)){
                return new JsonResponse(['message' => 'Could not find any beer'], 404);
            }
            $response = $serializer->serialize($beers, 'json');
            return new Response($response);

        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An error occured'], 500);
        }
    }

    /**
     * @Route("/beers/price/{from}/{to}")
     */
    public function getBeersByPriceRange(float $from, float $to) {
        $serializer = $this->get('jms_serializer');

        $from = $from * 100;
        $to = $to * 100;

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        try {
            $beers = $beerRepository->findByPriceRange($from, $to);
            if(!count($beers)){
                return new JsonResponse(['message' => 'Could not find any beer'], 404);
            }
            $response = $serializer->serialize($beers, 'json');
            return new Response($response);

        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An error occured'], 500);
        }
    }

    /**
     * @Route("/beers/countries")
     */
    public function getCountries() {
        $serializer = $this->get('jms_serializer');
        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        try {
            $countries = $beerRepository->findCountries();
            if(!count($countries)) {
                return new JsonResponse(['message' => 'Could not find any country'], 404);
            }
            return new JsonResponse($countries);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An error occured'], 500);
        }

    }

    /**
     * @Route("/beers/countries/{countryCode}", requirements={"countryCode"="[a-zA-Z]{2}"})
     */
    public function getBeersByCountryCode(string $countryCode) {
        $serializer = $this->get('jms_serializer');
        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        try {
            $beers = $beerRepository->findByCountryCode($countryCode);
            if(!count($beers)) {
                return new JsonResponse(['message' => 'Could not find any beer'], 404);
            }
            $response = $serializer->serialize($beers, 'json');
            return new Response($response);

        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An error occured'], 500);
        }
    }

    /**
     * @Route("/beers/types/{type}")
     */
    public function getBeersByType(string $type) {
        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        try {
            $beers = $beerRepository->findByType($type);
            if(!count($beers)) {
                return new JsonResponse(['message' => 'Could not find any beer'], 404);
            }
            $response = $serializer->serialize($beers, 'json');
            return new Response($response);

        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An error occured'], 500);
        }
    }


    /**
     * @Route("/beers/types")
     */
    public function getTypes() {
        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        try {
            $types = $beerRepository->findTypes();
            if(!count($types)) {
                return new JsonResponse(['message' => 'Could not find any type'], 404);
            }
            $response = $serializer->serialize($types, 'json');
            return new Response($response);

        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An error occured'], 500);
        }
    }

    /**
     * @Route("/beers/all")
     */
    public function getBeersByAll(Request $request){
        $name = $request->query->get('name') ? $request->query->get('name') : null;
        $from = $request->query->get('from') ? (int)$request->query->get('from') : null;
        $to = $request->query->get('to') ? (int)$request->query->get('to') : null;
        $country = $request->query->get('country') ? $request->query->get('country') : null;
        $type = $request->query->get('type') ? $request->query->get('type') : null;
        $brewerName = $request->query->get('brewerName') ? $request->query->get('brewerName') : null;

        $serializer = $this->get('jms_serializer');

        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);
        try {
            $beers = $beerRepository->findByAll($name, $from, $to, $country, $type, $brewerName);
            if(!count($beers)) {
                return new JsonResponse(['message' => 'Could not find any beer'], 404);
            }
            $response = $serializer->serialize($beers, 'json');
            return new Response($response);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            return new JsonResponse(['message' => 'An error occured'], 500);
        }
    }
}
