<?php

namespace App\Repository\Room;

use App\Entity\Room\Amenity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Amenity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Amenity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Amenity[]    findAll()
 * @method Amenity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmenityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Amenity::class);
    }

    // /**
    //  * @return Amenity[] Returns an array of Amenity objects
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
    public function findOneBySomeField($value): ?Amenity
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
