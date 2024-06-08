<?php

namespace App\Filter;

use App\Entity\MatchingCriteria;
use App\Entity\TaskType;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class TaskTypeIdsMatchingCriteriaFilter extends ArrayDataAbstractFilter
{
    public function buildQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $matchingCriteriaBuilder = new MatchingCriteriaQueryBuilder();
        $matchingCriteriaBuilder->buildIDsMatchingCriteriaQuery($queryBuilder, TaskType::class, 'tt', 'taskType', $data);
    }

    public static function getPropertyName(): string
    {
        return 'taskTypeIdsMatchingCriteria';
    }

    public static function getResourceClass(): string
    {
        return MatchingCriteria::class;
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            self::getPropertyName() => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'example' => '{"data":["1","2"]}',
                    'description' => 'Filter task type IDs by matching criteria.',
                ],
            ]
        ];
    }
}