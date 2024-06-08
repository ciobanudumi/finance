<?php

namespace App\Filter;

use App\Entity\TaskSet;
use App\SQLBuilder\TaskSetQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class TaskSetTaskCompanyFilter extends ArrayDataAbstractFilter
{
    public function buildQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $taskSetQueryBuilder = new TaskSetQueryBuilder();
        $taskSetQueryBuilder->buildTaskSetTaskCompanyQuery($queryBuilder, $data);
    }

    public static function getPropertyName(): string
    {
        return 'taskSetTaskCompany';
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
                    'description' => 'Filter task set & task by companies.',
                ],
            ]
        ];
    }
}