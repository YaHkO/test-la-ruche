<?php

namespace App\Repository;

use App\Entity\UploadOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UploadOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method UploadOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method UploadOrder[]    findAll()
 * @method UploadOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UploadOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UploadOrder::class);
    }

    // /**
    //  * @return UploadOrder[] Returns an array of UploadOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UploadOrder
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
