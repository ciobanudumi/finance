<?php

namespace App\Repository;

use App\Entity\MatchingCriteria;
use App\Entity\Task;
use App\Entity\TaskSet;
use App\Entity\TaskType;
use App\SQLBuilder\TaskQueryBuilder;
use App\SQLBuilder\TaskSetQueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskSet>
 *
 * @method TaskSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskSet[]    findAll()
 * @method TaskSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskSet::class);
    }

    public function save(TaskSet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TaskSet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param MatchingCriteria $matchingCriteria
     * @return array
     */
    public function findByMatchingCriteria(MatchingCriteria $matchingCriteria): array
    {
        $taskType = $matchingCriteria->getTaskType()->getName();

        $taskTypeMapping = TaskSetQueryBuilder::TASK_TYPES_MATCHING[$taskType];
        return $this->createQueryBuilder('ts')
            ->innerJoin(Task::class, 't', Join::WITH, 't.taskSet = ts.id')
            ->innerJoin(
                $taskTypeMapping['resourceClass'],
                $taskTypeMapping['alias'],
                Join::WITH,
                $taskTypeMapping['alias'] . '.taskSet = ts.id'
            )
            ->andWhere('ts.assignee is NULL')
            ->andWhere('t.company = :company')
            ->andWhere('t.region >= :minRegion')
            ->andWhere('t.region <= :maxRegion')
            ->setParameter('company', $matchingCriteria->getCompany())
            ->setParameter('minRegion', $matchingCriteria->getMinRegion())
            ->setParameter('maxRegion', $matchingCriteria->getMaxRegion())
            ->getQuery()
            ->getResult();
    }
}
