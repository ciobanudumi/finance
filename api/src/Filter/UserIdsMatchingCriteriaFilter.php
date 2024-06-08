<?php

namespace App\Filter;

use App\Entity\MatchingCriteria;
use App\Entity\User;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class UserIdsMatchingCriteriaFilter extends ArrayDataAbstractFilter
{
    public function buildQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $matchingCriteriaBuilder = new MatchingCriteriaQueryBuilder();
        $matchingCriteriaBuilder->buildIDsMatchingCriteriaQuery($queryBuilder, User::class, 'u', 'user', $data);
    }

    public static function getPropertyName(): string
    {
        return 'userIdsMatchingCriteria';
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
                    'description' => 'Filter user IDs by matching criteria.',
                ],
            ]
        ];
    }
}