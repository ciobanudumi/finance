<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\RegionMatchingCriteriaFilterDto;
use App\Entity\MatchingCriteria;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RegionMatchingCriteriaFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'regionMatchingCriteria';

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        ManagerRegistry $managerRegistry,
        LoggerInterface $logger = null,
        ?array $properties = null,
        ?NameConverterInterface $nameConverter = null
    ) {
        parent::__construct($managerRegistry, $logger, $properties, $nameConverter);
    }
    protected function filterProperty(string $property, mixed $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if ($property !== self::PROPERTY_NAME || $resourceClass !== MatchingCriteria::class) {
            return;
        }

        /** @var RegionMatchingCriteriaFilterDto $regionMatchingCriteriaFilterDto */
        $regionMatchingCriteriaFilterDto = $this->serializer->deserialize($value, RegionMatchingCriteriaFilterDto::class, "json");
        $this->validator->validate($regionMatchingCriteriaFilterDto);

        $matchingCriteriaBuilder = new MatchingCriteriaQueryBuilder();
        $matchingCriteriaBuilder->buildRegionMatchingCriteriaQuery($queryBuilder, $regionMatchingCriteriaFilterDto->region);
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            self::PROPERTY_NAME => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'example' => '{"region":1234}',
                    'description' => 'Filter region by matching criteria.',
                ],
            ]
        ];
    }
}