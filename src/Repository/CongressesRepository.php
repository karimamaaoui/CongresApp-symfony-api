<?php

namespace App\Repository;

use App\Entity\Congresses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Congresses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Congresses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Congresses[]    findAll()
 * @method Congresses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CongressesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Congresses::class);
    }

    // /**
    //  * @return Congresses[] Returns an array of Congresses objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Congresses
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
