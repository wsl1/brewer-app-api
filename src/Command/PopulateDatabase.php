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

        $brewerRepository = $this->getContainer()->get('doctrine')->getRepository(Brewer::class);
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $client = new Client([
            'base_uri' => 'http://ontariobeerapi.ca/products/'
        ]);
        $response = $client->request('GET')->getBody()->getContents();
        $beers = json_decode($response, true);

        foreach($beers as $product) {

            $matches = [];
            preg_match_all('/([0-9]+)/',$product['size'], $matches);
            $numberOfCans = $matches[0][0];
            $canCapacity = $matches[0][1];
            $totalPrice = (float)$product['price'];

            $pricePerLitre = $this->calculatePricePerLitre($numberOfCans, $canCapacity, $totalPrice);
            $pricePerLitre = (int)($pricePerLitre * 100);

            $brewers = $brewerRepository->findByName($product['brewer']);
            if($brewers) {
                $brewer = $brewers[0];
            } else {
                $brewer = new Brewer($product['brewer']);
                try {
                    $entityManager->persist($brewer);
                    $entityManager->flush();
                } catch (\Exception $e) {
                    $brewer = null;
                    $output->writeln('Could not insert a brewer');
                }

            }
            $beer = new Beer($product['name'], $pricePerLitre, $product['country'], $product['type'], $product['image_url'], $brewer);
            try {
                $entityManager->persist($beer);
                $entityManager->flush();
            } catch (\Exception $e) {
                $output->writeln('Could not insert a beer');
            }

        }

    }

    private function calculatePricePerLitre(int $numberOfCans, int $canCapacity, float $totalPrice): float {

        $canCapacity = (int)$canCapacity / 1000; // convert to litres
        $pricePerLitre = (int)$totalPrice / $canCapacity;

        return $pricePerLitre;
    }
}