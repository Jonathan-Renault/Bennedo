<?php

namespace App\Repository;

use App\Entity\Admin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Admin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Admin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Admin[]    findAll()
 * @method Admin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Admin::class);
    }

    // /**
    //  * @return Admin[] Returns an array of Admin objects
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
    public function findOneBySomeField($value): ?Admin
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllAdmin()
    {
        $query = $this->createQueryBuilder('c')
            ->where('1 = 1')
            ->orderBy('c.created_at', 'DESC')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function findAdmin($id)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.id = :id')
            ->setParameter(':id', $id)
            ->getQuery();
        return $query->getArrayResult();
    }

    public function findAdminByLog($login)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.login = :login')
            ->setParameter(':login', $login)
            ->getQuery();
        return $query->getArrayResult();
    }

    public function removeAdmin($id)
    {
        $query = $this->getEntityManager()->getConnection();

        $sql = "DELETE FROM admin
                        WHERE id='" . $id . "'";
        $statement = $query->prepare($sql);
        $statement->execute();
    }

    public function updateAdmin(Admin $admin): Admin
    {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();
        return $admin;
    }

}
