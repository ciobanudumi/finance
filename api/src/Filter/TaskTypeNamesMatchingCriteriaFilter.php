<?php

declare(strict_types=1);

namespace App\Filter;

use App\Entity\MatchingCriteria;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class TaskTypeNamesMatchingCriteriaFilter extends ArrayDataAbstractFilter
{
    public function buildQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $matchingCriteriaBuilder = new MatchingCriteriaQueryBuilder();
        $matchingCriteriaBuilder->buildTaskTypesNamesMatchingCriteriaQuery($queryBuilder, $data);
    }

    public static function getPropertyName(): string
    {
        return 'taskTypeNamesMatchingCriteria';
    }

    public static function getResourceClass(): string
    {
        return MatchingCriteria::class;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            self::getPropertyName() => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'example' => '{"data":["task_onsite_installation", "task_patch_install"]}',
                    'description' => 'Filter task type names by matching criteria.',
                ],
            ]
        ];
    }
}