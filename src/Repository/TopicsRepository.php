<?php

namespace App\Repository;

use App\Entity\Topics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Topics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topics[]    findAll()
 * @method Topics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topics::class);
    }

    // /**
    //  * @return Topics[] Returns an array of Topics objects
    //  */
    
    public function searchTopics($value)
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.users', 'user')
            ->where('t.title LIKE :titre')
            ->setParameter('titre', '%'.$value.'%')
            ->orWhere('t.text LIKE :contenu')
            ->setParameter('contenu', '%'.$value.'%')
            ->orWhere('user.pseudo LIKE :pseudo')
            ->setParameter('pseudo', '%'.$value.'%')
            ->orderBy('t.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Topics
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
