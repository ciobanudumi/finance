<?php

namespace App\Repository;

use App\Entity\TaskOnsiteInstallation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskOnsiteInstallation>
 *
 * @method TaskOnsiteInstallation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskOnsiteInstallation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskOnsiteInstallation[]    findAll()
 * @method TaskOnsiteInstallation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskOnsiteInstallationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskOnsiteInstallation::class);
    }

    public function save(TaskOnsiteInstallation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TaskOnsiteInstallation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TaskOnsiteInstallation[] Returns an array of TaskOnsiteInstallation objects
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

//    public function findOneBySomeField($value): ?TaskOnsiteInstallation
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
