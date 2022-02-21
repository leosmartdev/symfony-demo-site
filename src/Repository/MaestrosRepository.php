<?php

namespace App\Repository;

use App\Entity\Maestros;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Maestros|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maestros|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maestros[]    findAll()
 * @method Maestros[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaestrosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maestros::class);
    }

    // /**
    //  * @return Maestros[] Returns an array of Maestros objects
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

    public function findAll() {
        return $this->createQueryBuilder('m')
            ->andWhere('m.deleted = :val')
            ->setParameter('val', false)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Maestros
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
