<?php

namespace App\Repository;

use App\Entity\Brewer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Brewer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brewer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brewer[]    findAll()
 * @method Brewer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrewerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Brewer::class);
    }

    public function findByName(string $name): ?array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllBrewers(): ?array {

        // select br.id,br.name, count(b.id) from brewers br inner join beers b on br.id=b.brewer group by br.id;
        $sql = "select br.id,br.name, count(b.id) as numberOfBeers from brewers br inner join beers b on br.id=b.brewer group by br.id;";
        $entityManager = $this->getEntityManager();
        $query = $entityManager->getConnection()->prepare($sql);
        $query->execute();
        $brewers = $query->fetchAll();

        return $brewers;

    }
}
