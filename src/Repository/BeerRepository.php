<?php

namespace App\Repository;

use App\Entity\Beer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use League\ISO3166\ISO3166;

/**
 * @method Beer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beer[]    findAll()
 * @method Beer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeerRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Beer::class);
    }

    public function findByName(string $name): array
    {
        $name = strtoupper($name);
        return $this->createQueryBuilder('b')
            ->andWhere('upper(b.name) = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByPriceRange(int $from, int $to): ?array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.pricePerLitre => :from')
            ->andWhere('b.pricePerLitre =< :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCountries(): array
    {
        return $this->createQueryBuilder('b')
            ->select('DISTINCT b.country')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByCountryCode(string $countryCode): array
    {

        $data = (new ISO3166)->alpha2($countryCode);
        $country = $data['name'];

        return $this->createQueryBuilder('b')
            ->andWhere('b.country = :country')
            ->setParameter('country', $country)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByType(string $type): array
    {
        $type = strtoupper($type);
        return $this->createQueryBuilder('b')
            ->andWhere('upper(b.type) = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAll(?string $name, ?int $from, ?int $to, ?string $country, ?string $type, ?string $brewerName): array {

        $qb = $this->createQueryBuilder('b');

        if($brewerName){
            $brewerName = strtoupper($brewerName);
            $qb->select('b.id,b.name, b.pricePerLitre, b.country, b.type, br.name');
            $qb->andWhere('upper(b.brewer) LIKE :brewerName%');
            $qb->setParameter('brewerName', $brewerName);
            $qb->innerJoin('b', 'brewers', 'br', 'br.id = b.brewer');
        }

        if($name) {
            $name = strtoupper($name);
            $qb->andWhere('upper(b.name) = :name')
                ->setParameter('name', $name);
        }
        if($from) {
            $qb->andWhere('b.pricePerLitre) >= :from')
                ->setParameter('from', $from);

        }

        if($to) {
            $qb->andWhere('b.pricePerLitre) <= :to')
                ->setParameter('to', $to);
        }
        if($country) {
            $country = strtoupper($country);
            $qb->andWhere('upper(b.country) LIKE :country%')
                ->setParameter('country', $country);
        }
        if($type) {
            $type = strtoupper($type);
            $qb->andWhere('upper(b.type) LIKE :type%')
                ->setParameter('type', $type);
        }


        return $this->createQueryBuilder('b')
            ->getQuery()
            ->getResult()
            ;
    }

}
