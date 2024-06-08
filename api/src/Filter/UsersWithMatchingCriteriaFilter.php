<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\User;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class UsersWithMatchingCriteriaFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'usersWithMatchingCriteria';

    /**
     * @inheritDoc
     */
    protected function filterProperty(string $property, mixed $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if ($property !== self::PROPERTY_NAME || $resourceClass !== User::class) {
            return;
        }

        if ($value === true) {
            $matchingCriteriaBuilder = new MatchingCriteriaQueryBuilder();
            $matchingCriteriaBuilder->buildWithMatchingCriteriaQuery($queryBuilder, 'user');
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
                    'description' => 'Filter users with matching criteria.',
                ],
            ]
        ];
    }
}