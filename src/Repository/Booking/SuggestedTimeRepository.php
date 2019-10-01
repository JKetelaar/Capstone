<?php

namespace App\Repository\Booking;

use App\Entity\Booking\SuggestedTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SuggestedTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuggestedTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuggestedTime[]    findAll()
 * @method SuggestedTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuggestedTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuggestedTime::class);
    }

    // /**
    //  * @return SuggestedTime[] Returns an array of SuggestedTime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SuggestedTime
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
