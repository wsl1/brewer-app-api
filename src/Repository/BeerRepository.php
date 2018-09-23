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

    public function findByCountry(string $country): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.country = :country')
            ->setParameter('country', $country)
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
}
