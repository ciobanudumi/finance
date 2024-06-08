<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\TaskSet;
use App\SQLBuilder\TaskSetQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class TaskSetAssigneeFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'taskSetAssignee';

    /**
     * @param string $property
     * @param mixed $value
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param Operation|null $operation
     * @param array $context
     * @return void
     */
    protected function filterProperty(
        string $property,
        mixed $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void
    {
        if ($property !== self::PROPERTY_NAME || $resourceClass !== TaskSet::class) {
            return;
        }

        $taskSetQueryBuilder = new TaskSetQueryBuilder();
        $taskSetQueryBuilder->buildTaskSetAssigneeQueryBuilder($queryBuilder, $value);
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            self::PROPERTY_NAME => [
                'property' => null,
                'type' => 'bool',
                'required' => false,
                'openapi' => [
                    'example' => 'true',
                    'description' => 'Filter task set with or without assignee.',
                ],
            ]
        ];
    }

}