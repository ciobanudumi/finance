<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\TaskSet;
use App\SQLBuilder\TaskSetQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class TaskSetPlannedFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'taskSetPlanned';

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

        if (is_bool($value)) {
            $taskSetQueryBuilder = new TaskSetQueryBuilder();
            $taskSetQueryBuilder->buildTaskSetPlannedQueryBuilder($queryBuilder, $value);
        }
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
                    'description' => 'Filter task set with or without planned date.',
                ],
            ]
        ];
    }

}