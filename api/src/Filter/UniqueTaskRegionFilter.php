<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Task;
use App\SQLBuilder\TaskQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class UniqueTaskRegionFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'uniqueTaskRegion';

    /**
     * @inheritDoc
     */
    protected function filterProperty(string $property, mixed $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if ($property !== self::PROPERTY_NAME || $resourceClass !== Task::class) {
            return;
        }

        if ($value === true) {
            $taskSetQueryBuilder = new TaskQueryBuilder();
            $taskSetQueryBuilder->buildUniqueRegionFromTask($queryBuilder);
        }
    }

    /**
     * @inheritDoc
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            self::PROPERTY_NAME => [
                'property' => null,
                'type' => 'bool',
                'required' => false,
                'openapi' => [
                    'example' => 'true',
                    'description' => 'Filter unique regions from tasks.',
                ],
            ]
        ];
    }

}