<?php

namespace App\Command;

use App\Entity\Beer;
use App\Entity\Brewer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class PopulateDatabase extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:populate-database')

            // the short description shown while running "php bin/console list"
            ->setDescription('Populates database with data from http://ontariobeerapi.ca/ API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://ontariobeerapi.ca/products/'
        ]);
        $response = $client->request('GET')->getBody()->getContents();
        $beers = json_decode($response, true);
        //dump(is_array($response[0]));
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        //$entityManager->persist($product);
        //$entityManager->flush();
        foreach($response as $product) {

            //$string = "552  \u00d7  Can 473\u00a0ml";

            $matches = [];
            preg_match_all('/([0-9]+)/',$product['size'], $matches);

            $canNumber = $matches[0][0];
            $canCapacity = $matches[0][3];
            $canCapacity = (int)$canCapacity / 1000; // convert to litres
            $price = $product['price'];
            $pricePerLitre = (int)$price / $canCapacity;

            $brewer = new Brewer($product['brewer']);

            $beer = new Beer($product['name'], $pricePerLitre, $product['country'], $product['type'], $brewer);
        }

    }

    private function calculatePricePerLitre(int $numberOfCans, int $canCapacity, float $totalPrice) {

        $canCapacity = (int)$canCapacity / 1000; // convert to litres
        $pricePerLitre = (int)$totalPrice / $canCapacity;

        return $pricePerLitre;
    }
}