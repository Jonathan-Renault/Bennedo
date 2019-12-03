<?php

namespace App\Repository;

use App\Entity\ConsumerHasBin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ConsumerHasBin|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsumerHasBin|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsumerHasBin[]    findAll()
 * @method ConsumerHasBin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsumerHasBinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsumerHasBin::class);
    }

    // /**
    //  * @return ConsumerHasBin[] Returns an array of ConsumerHasBin objects
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
    public function findOneBySomeField($value): ?ConsumerHasBin
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
