<?php

namespace App\Repository;

use App\Entity\Dislikes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dislikes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dislikes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dislikes[]    findAll()
 * @method Dislikes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DislikesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dislikes::class);
    }

    // /**
    //  * @return Dislikes[] Returns an array of Dislikes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dislikes
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
