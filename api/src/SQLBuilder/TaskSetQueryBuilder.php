<?php

declare(strict_types=1);

namespace App\SQLBuilder;

use App\Dto\MultiOrderDto;
use App\Dto\OrderDto;
use App\Entity\MatchingCriteria;
use App\Entity\Task;
use App\Entity\TaskOnsiteInstallation;
use App\Entity\TaskPatchInstall;
use App\Entity\TaskPatchMigrate;
use App\Entity\TaskPatchRemove;
use App\Entity\TaskType;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\ORM\QueryBuilder;

class TaskSetQueryBuilder
{
    public const TASK_TYPES_MATCHING = [
        TaskType::TASK_PATCH_INSTALL => [
            'alias' => 'tstpi',
            'resourceClass' => TaskPatchInstall::class
        ],
        TaskType::TASK_PATCH_MIGRATE => [
            'alias' => 'tstpm',
            'resourceClass' => TaskPatchMigrate::class
        ],
        TaskType::TASK_PATCH_REMOVE => [
            'alias' => 'tstpr',
            'resourceClass' => TaskPatchRemove::class
        ],
        TaskType::TASK_ONSITE_INSTALLATION => [
            'alias' => 'tstoi',
            'resourceClass' => TaskOnsiteInstallation::class
        ]
    ];

    public function buildTaskSetsForTaskMatchingCriteriaQuery(QueryBuilder $queryBuilder, int $companyId, int $region, int $taskTypeId): QueryBuilder
    {
        $queryBuilder->leftJoin(MatchingCriteria::class, 'mc', Join::WITH, 'mc.user = o.assignee')
            ->andWhere('mc.company IS NULL or mc.company = :company')
            ->andWhere('mc.taskType IS NULL or mc.taskType = :taskType')
            ->andWhere('mc.minRegion IS NULL or mc.minRegion <= :region')
            ->andWhere('mc.maxRegion IS NULL or mc.maxRegion >= :region')
            ->setParameter('company', $companyId)
            ->setParameter('taskType', $taskTypeId)
            ->setParameter('region', $region)
            ->groupBy('o.id');

        return $queryBuilder;
    }

    public function buildExcludeTaskSetOfTaskQuery(QueryBuilder $queryBuilder, int $taskSetId): QueryBuilder
    {
        $queryBuilder->andWhere('o.id != :taskSetId')
            ->setParameter('taskSetId', $taskSetId)
            ->groupBy('o.id');

        return $queryBuilder;
    }

    public function buildTaskSetStatusQuery(QueryBuilder $queryBuilder, array $taskSetStatuses): QueryBuilder
    {
        $queryBuilder->andWhere('o.status IN (:statuses)')
            ->setParameter('statuses', $taskSetStatuses);

        return $queryBuilder;
    }

    public function buildTaskSetTaskCompanyQuery(QueryBuilder $queryBuilder, array $companyIds): QueryBuilder
    {
        $alias = 'tstc';
        $queryBuilder->leftJoin(Task::class, $alias, Join::WITH, $alias.'.taskSet = o.id')
            ->andWhere($alias.'.company IN (:companyIds)')
            ->setParameter('companyIds', $companyIds);


        return $queryBuilder;
    }

    public function buildTaskSetTaskRegionQuery(QueryBuilder $queryBuilder, array $regions): QueryBuilder
    {
        $alias = 'tstr';
        $queryBuilder->leftJoin(Task::class, $alias, Join::WITH, $alias.'.taskSet = o.id')
            ->andWhere($alias.'.region IN (:regions)')
            ->setParameter('regions', $regions);

        return $queryBuilder;
    }

    public function buildTaskSetTaskTypeQuery(QueryBuilder $queryBuilder, array $taskTypes): QueryBuilder
    {
        foreach ($taskTypes as $taskType) {
            if (in_array($taskType, array_keys(self::TASK_TYPES_MATCHING))) {
                $queryBuilder->innerJoin(
                    self::TASK_TYPES_MATCHING[$taskType]['resourceClass'],
                    self::TASK_TYPES_MATCHING[$taskType]['alias'],
                    Join::WITH,
                    self::TASK_TYPES_MATCHING[$taskType]['alias'] . '.taskSet = o.id'
                );
            }
        }

        return $queryBuilder;
    }

    public function buildTaskSetPlannedQueryBuilder(QueryBuilder $queryBuilder, ?bool $value): QueryBuilder
    {
        if ($value === true) {
            $queryBuilder->andWhere('o.planned IS NOT NULL');
        } elseif ($value === false) {
            $queryBuilder->andWhere('o.planned IS NULL');
        }

        return $queryBuilder;
    }

    public function buildTaskSetAssigneeQueryBuilder(QueryBuilder $queryBuilder, ?bool $value): QueryBuilder
    {
        if ($value === true) {
            $queryBuilder->andWhere('o.assignee IS NOT NULL');
        } elseif ($value === false) {
            $queryBuilder->andWhere('o.assignee IS NULL');
        }

        return $queryBuilder;
    }

    public function buildCompaniesWithTasksQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $alias = 'tsc';
        $queryBuilder->innerJoin(Task::class, $alias, Join::WITH, $alias.'.company = o.id')
            ->groupBy('o.id');

        return $queryBuilder;
    }

    public function buildTaskSetOrderQueryBuilder(QueryBuilder $queryBuilder, MultiOrderDto $orders): QueryBuilder
    {
        /** @var OrderDto $order */
        foreach ($orders->data as $order) {
            $newOrderBy = new OrderBy('o.'.$order->sortBy, $order->order);
            $queryBuilder->addOrderBy($newOrderBy);
        }

        return $queryBuilder;
    }
}