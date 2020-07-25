<?php

namespace App\Repository;

use App\Entity\LineasPedidos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LineasPedidos|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineasPedidos|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineasPedidos[]    findAll()
 * @method LineasPedidos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineasPedidosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineasPedidos::class);
    }

    // /**
    //  * @return LineasPedidos[] Returns an array of LineasPedidos objects
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
    public function findOneBySomeField($value): ?LineasPedidos
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
