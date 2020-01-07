<?php

namespace App\Repository;

use App\Entity\Consumer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Consumer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consumer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consumer[]    findAll()
 * @method Consumer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsumerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consumer::class);
    }

    // /**
    //  * @return Consumer[] Returns an array of Consumer objects
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
    public function findOneBySomeField($value): ?Consumer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findBin()
    {
        $query = $this->createQueryBuilder('c')
            ->leftJoin('bin', 'b')
            ->where('ST_DWithin(c.coord, b.coord, 500)')
            ->select('b.id','b.city', 'b.city_code', 'b.coords', 'b.created_at', 'b.name', 'b.updated_at')
            ->getQuery()
            ;

        return $query->getResult();

    }
}
