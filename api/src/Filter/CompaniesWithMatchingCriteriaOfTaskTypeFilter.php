<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Company;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\QueryBuilder;

class CompaniesWithMatchingCriteriaOfTaskTypeFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'companiesWithMatchingCriteriaOfTaskType';

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
        $matchingCriteriaBuilder->buildWithMatchingCriteriaOfTaskTypeQuery($queryBuilder, $value, 'company');
    }

    /**
     * @inheritDoc
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            self::PROPERTY_NAME => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'example' => 'task_onsite_installation',
                    'description' => 'Filter companies which have matching criteria of given task type.',
                ],
            ]
        ];
    }
}