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

//    /**
//     * @return Brewer[] Returns an array of Brewer objects
//     */

    public function findByName(string $name): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Brewer
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
