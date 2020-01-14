<?php

namespace App\Repository;

use App\Entity\Bin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use http\Header\Parser;
use Jsor\Doctrine\PostGIS\Functions\ST_DWithin;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Bin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bin[]    findAll()
 * @method Bin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bin::class);
    }

    // /**
    //  * @return Bin[] Returns an array of Bin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bin
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllBin()
    {
        $query = $this->createQueryBuilder('b')
            ->select('b.id','b.coords','b.name','b.city','b.city_code','b.created_at','b.updated_at')
            ->getQuery()
            ;
        return $query->getResult();
    }

    public function findOnebycoords($coord,$coord1)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.coords = ST_Point(:val,:val1)')
            ->setParameter(':val',$coord)
            ->setParameter(':val1',$coord1)
            ->getQuery()
            ;
        return $query->getResult();
    }



    public function findbycoord($coord,$coord2,$rayon)
    {
        $query = $this->createQueryBuilder('b')
            ->where("ST_DWithin(b.coords, Geography(ST_SetSRID(ST_Point(:val,:val2),4326)), :val3) = true")
            ->setParameter(':val', $coord)
            ->setParameter(':val2', $coord2)
            ->setParameter(':val3',$rayon)
            ->select('b.id','b.coords','b.name','b.city','b.city_code','b.created_at','b.updated_at')
            ->getQuery()
        ;
        return $query->getResult();
    }




}