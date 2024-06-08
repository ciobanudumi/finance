<?php

namespace App\Repository;

use App\Entity\TaskPatchInstall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskPatchInstall>
 *
 * @method TaskPatchInstall|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskPatchInstall|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskPatchInstall[]    findAll()
 * @method TaskPatchInstall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskPatchInstallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskPatchInstall::class);
    }

    public function save(TaskPatchInstall $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TaskPatchInstall $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TaskConstructPath[] Returns an array of TaskConstructPath objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TaskConstructPath
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
