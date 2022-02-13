<?php

namespace App\Repository;

use App\Entity\ManageM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ManageM|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManageM|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManageM[]    findAll()
 * @method ManageM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManageMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManageM::class);
    }

    // /**
    //  * @return ManageM[] Returns an array of ManageM objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ManageM
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
