<?php

namespace App\Repository;

use App\Entity\LineasCarrito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LineasCarrito|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineasCarrito|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineasCarrito[]    findAll()
 * @method LineasCarrito[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineasCarritoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineasCarrito::class);
    }

    // /**
    //  * @return LineasCarrito[] Returns an array of LineasCarrito objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LineasCarrito
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
