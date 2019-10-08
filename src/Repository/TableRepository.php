<?php

namespace App\Repository;

use App\Entity\BookingTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BookingTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingTable[]    findAll()
 * @method BookingTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingTable::class);
    }

    // /**
    //  * @return BookingTable[] Returns an array of BookingTable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookingTable
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
