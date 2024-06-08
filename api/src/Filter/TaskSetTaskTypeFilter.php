<?php

namespace App\Filter;

use App\Entity\TaskSet;
use App\Entity\TaskType;
use App\SQLBuilder\TaskSetQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class TaskSetTaskTypeFilter extends ArrayDataAbstractFilter
{
    public function buildQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $taskTypes = $this->entityManager->getRepository(TaskType::class)->findBy(['id' => $data]);
        if ($taskTypes) {
            $taskTypeNames = [];
            /** @var TaskType $taskType */
            foreach ($taskTypes as $taskType) {
                $taskTypeNames[] = $taskType->getName();
            }

            $taskSetQueryBuilder = new TaskSetQueryBuilder();
            $taskSetQueryBuilder->buildTaskSetTaskTypeQuery($queryBuilder, $taskTypeNames);
        }
    }

    public static function getPropertyName(): string
    {
        return 'taskSetTaskType';
    }

    public static function getResourceClass(): string
    {
        return TaskSet::class;
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            self::getPropertyName() => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'example' => '{"data":[1, 2, 3]}',
                    'description' => 'Filter task set by task type.',
                ],
            ]
        ];
    }
}