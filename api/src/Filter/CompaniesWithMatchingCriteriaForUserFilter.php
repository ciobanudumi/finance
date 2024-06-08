<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Company;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class CompaniesWithMatchingCriteriaForUserFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'companiesWithMatchingCriteriaForUser';

    /**
     * @inheritDoc
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
        if ($property !== self::PROPERTY_NAME || $resourceClass !== Company::class) {
            return;
        }

        $matchingCriteriaBuilder = new MatchingCriteriaQueryBuilder();
        $matchingCriteriaBuilder->buildWithMatchingCriteriaForUserQuery($queryBuilder, $value, 'company');
    }

    /**
     * @inheritDoc
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            self::PROPERTY_NAME => [
                'property' => null,
                'type' => 'int',
                'required' => false,
                'openapi' => [
                    'example' => 3,
                    'description' => 'Filter companies which have matching criteria for given user.',
                ],
            ]
        ];
    }
}