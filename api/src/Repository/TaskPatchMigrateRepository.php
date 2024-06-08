<?php

namespace App\Repository;

use App\Entity\TaskPatchMigrate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskPatchMigrate>
 *
 * @method TaskPatchMigrate|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskPatchMigrate|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskPatchMigrate[]    findAll()
 * @method TaskPatchMigrate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskPatchMigrateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskPatchMigrate::class);
    }

    public function save(TaskPatchMigrate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TaskPatchMigrate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
