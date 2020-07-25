<?php

namespace App\Repository;

use App\Entity\DatosFacturacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DatosFacturacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatosFacturacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatosFacturacion[]    findAll()
 * @method DatosFacturacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatosFacturacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatosFacturacion::class);
    }

    // /**
    //  * @return DatosFacturacion[] Returns an array of DatosFacturacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DatosFacturacion
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
