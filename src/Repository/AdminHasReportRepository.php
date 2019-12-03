<?php

namespace App\Repository;

use App\Entity\AdminHasReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AdminHasReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminHasReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminHasReport[]    findAll()
 * @method AdminHasReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminHasReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminHasReport::class);
    }

    // /**
    //  * @return AdminHasReport[] Returns an array of AdminHasReport objects
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
    public function findOneBySomeField($value): ?AdminHasReport
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
