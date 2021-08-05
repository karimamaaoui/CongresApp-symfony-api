<?php

namespace App\Repository;

use App\Entity\Congres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Congres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Congres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Congres[]    findAll()
 * @method Congres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CongresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Congres::class);
    }

    // /**
    //  * @return Congres[] Returns an array of Congres objects
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
    public function findOneBySomeField($value): ?Congres
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
