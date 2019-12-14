<?php

namespace App\Repository;

use App\Entity\Report;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

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

    /**
     * @return Report[]
     */
    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Report[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }

    public function findAllReport()
    {
        $query = $this->createQueryBuilder('c')
            ->where('1 = 1')
            ->orderBy('c.created_at', 'DESC')
            ->getQuery();
        return $query->getArrayResult();

    }


    public function findReport($id)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.id = :id')
            ->set(':id', $id)
            ->getQuery();
        return $query->getArrayResult();

    }

    public function removeReport($id)
    {
        $query = $this->getEntityManager()->getConnection();

        $sql = "DELETE FROM report where id='" . $id . "'";

        $statement = $query->prepare($sql);
        $statement->execute();
    }


}