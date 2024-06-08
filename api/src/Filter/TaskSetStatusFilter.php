<?php

namespace App\Filter;

use App\Entity\TaskSet;
use App\SQLBuilder\TaskSetQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class TaskSetStatusFilter extends ArrayDataAbstractFilter
{
    public function buildQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $taskSetQueryBuilder = new TaskSetQueryBuilder();
        $taskSetQueryBuilder->buildTaskSetStatusQuery($queryBuilder, $data);
    }

    public static function getPropertyName(): string
    {
        return 'taskSetStatus';
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
                    'example' => '{"data":["new", "to_do", "hold", "cancelled", "completed"]}',
                    'description' => 'Filter task set by status.',
                ],
            ]
        ];
    }
}