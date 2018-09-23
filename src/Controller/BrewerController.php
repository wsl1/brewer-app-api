<?php

namespace App\Controller;

use App\Entity\Brewer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrewerController extends Controller
{
    /**
     * @Route("/brewers/{id}", name="brewers", requirements={"id"="\d+"})
     */
    public function getBrewerById($id)
    {
        $serializer = $this->get('jms_serializer');

        $brewerRepository = $this->getDoctrine()->getRepository(Brewer::class);
        $brewer = $brewerRepository->find($id);

        $response = $serializer->serialize($brewer, 'json');
        return new Response($response);
    }
}
