<?php

namespace App\Repository;

use App\Entity\TaskPatchRemove;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskPatchRemove>
 *
 * @method TaskPatchRemove|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskPatchRemove|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskPatchRemove[]    findAll()
 * @method TaskPatchRemove[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskPatchRemoveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskPatchRemove::class);
    }

    public function save(TaskPatchRemove $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TaskPatchRemove $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
