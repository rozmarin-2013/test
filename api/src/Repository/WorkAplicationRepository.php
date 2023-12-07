<?php

namespace App\Repository;

use App\Entity\WorkAplication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkAplication>
 *
 * @method WorkAplication|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkAplication|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkAplication[]    findAll()
 * @method WorkAplication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkAplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkAplication::class);
    }

//    /**
//     * @return WorkAplication[] Returns an array of WorkAplication objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WorkAplication
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
