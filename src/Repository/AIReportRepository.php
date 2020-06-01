<?php

namespace App\Repository;

use App\Entity\AIReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AIReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method AIReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method AIReport[]    findAll()
 * @method AIReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AIReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AIReport::class);
    }

    // /**
    //  * @return AIReport[] Returns an array of AIReport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AIReport
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
