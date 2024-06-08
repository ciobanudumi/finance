<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Company;
use App\SQLBuilder\TaskSetQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class CompaniesWithTasksFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'companiesWithTasks';

    /**
     * @inheritDoc
     */
    protected function filterProperty(string $property, mixed $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if ($property !== self::PROPERTY_NAME || $resourceClass !== Company::class) {
            return;
        }

        if ($value === true) {
            $taskSetQueryBuilder = new TaskSetQueryBuilder();
            $taskSetQueryBuilder->buildCompaniesWithTasksQuery($queryBuilder);
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
                    'description' => 'Filter companies with tasks.',
                ],
            ]
        ];
    }
}