<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\TaskType;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class TaskTypesWithMatchingCriteriaFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'taskTypesWithMatchingCriteria';

    /**
     * @inheritDoc
     */
    protected function filterProperty(string $property, mixed $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if ($property !== self::PROPERTY_NAME || $resourceClass !== TaskType::class) {
            return;
        }

        if ($value === true) {
            $matchingCriteriaBuilder = new MatchingCriteriaQueryBuilder();
            $matchingCriteriaBuilder->buildWithMatchingCriteriaQuery($queryBuilder, 'taskType');
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
                    'description' => 'Filter task types with matching criteria.',
                ],
            ]
        ];
    }
}