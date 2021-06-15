<?php

namespace App\Repository;

use App\Entity\PropertyAudit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertyAudit|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyAudit|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyAudit[]    findAll()
 * @method PropertyAudit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyAuditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyAudit::class);
    }

    // /**
    //  * @return PropertyAudit[] Returns an array of PropertyAudit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PropertyAudit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
