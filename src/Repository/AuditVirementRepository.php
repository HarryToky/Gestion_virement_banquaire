<?php

namespace App\Repository;

use App\Entity\AuditVirement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuditVirement>
 *
 * @method AuditVirement|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditVirement|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditVirement[]    findAll()
 * @method AuditVirement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditVirementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditVirement::class);
    }

//    /**
//     * @return AuditVirement[] Returns an array of AuditVirement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AuditVirement
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
