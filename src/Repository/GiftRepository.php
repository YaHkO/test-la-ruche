<?php

namespace App\Repository;

use App\Entity\Gift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gift|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gift|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gift[]    findAll()
 * @method Gift[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gift::class);
    }

    /**
     * @return int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countGift()
    {
        return $this->createQueryBuilder('g')
            ->select('count(g.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findGiftByCode(): array
    {
        return $this->createQueryBuilder('g')
            ->select('count(g.id) as code_number, g.code')
            ->groupBy('g.code')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findOneGiftByMinPrice(): ?float
    {
        return (float) $this->createQueryBuilder('g')
            ->select('MIN(g.price)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findOneGiftByMaxPrice(): ?float
    {
        return (float) $this->createQueryBuilder('g')
            ->select('MAX(g.price)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
