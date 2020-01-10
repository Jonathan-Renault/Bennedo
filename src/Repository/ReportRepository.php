<?php

namespace App\Repository;

use App\Entity\Report;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Report|null find($id, $lockMode = null, $lockVersion = null)
 * @method Report|null findOneBy(array $criteria, array $orderBy = null)
 * @method Report[]    findAll()
 * @method Report[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    // /**
    //  * @return Report[] Returns an array of Report objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Report
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllReports() {
        $query = $this->createQueryBuilder('c')
            ->where('1 = 1')
            ->orderBy('c.created_at','DESC')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function findActiveReports() {
        $query = $this->createQueryBuilder('c')
            ->where('c.status = :status')
            ->setParameter(':status', "active")
            ->orderBy('c.created_at','ASC')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function findOneReport($id) {
        $query = $this->createQueryBuilder('c')
            ->where('c.id = :id')
            ->setParameter(':id',$id)
            ->getQuery();

        return $query->getArrayResult();
    }

    public function findIfReportIsActive($idBin) {
        $query = $this->createQueryBuilder('c')
            ->where('c.id_bin = :id AND c.status = :status')
            ->setParameter(':id',$idBin)
            ->setParameter(':status', 'active')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function getLastReport() {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM report WHERE status = "active" ORDER BY created_at DESC LIMIT 1';
    }

    public function updateReport(Report $report): Report
    {
        $this->getEntityManager()->persist($report);
        $this->getEntityManager()->flush();
        return $report;
    }

    public function cleanReports() {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'TRUNCATE TABLE report CASCADE';
        $statement = $conn->prepare($sql);
        $statement->execute();
    }
}
