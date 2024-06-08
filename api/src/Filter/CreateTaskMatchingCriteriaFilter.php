<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\MatchingCriteriaFilterDto;
use App\Entity\TaskType;
use App\Entity\User;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CreateTaskMatchingCriteriaFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'createTaskMatchingCriteria';

    public function __construct(
        private readonly SerializerInterface    $serializer,
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
        ManagerRegistry                         $managerRegistry,
        LoggerInterface                         $logger = null,
        ?array                                  $properties = null,
        ?NameConverterInterface                 $nameConverter = null)
    {
        parent::__construct($managerRegistry, $logger, $properties, $nameConverter);
    }

    /**
     * @inheritDoc
     */
    protected function filterProperty(string $property, mixed $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if($property !== self::PROPERTY_NAME || $resourceClass !== User::class) {
            return;
        }
        /** @var MatchingCriteriaFilterDto $filters */
        $filters = $this->serializer->deserialize($value, MatchingCriteriaFilterDto::class, "json");
        $this->validator->validate($filters);

        $taskTypesRepo = $this->entityManager->getRepository(TaskType::class);

        $filters->taskType = (string) $taskTypesRepo->findOneBy(['name'=>$filters->taskType])->getId();

        $matchingCriteriaBuilder = new MatchingCriteriaQueryBuilder();
        $matchingCriteriaBuilder->buildQuery($queryBuilder, [$filters]);

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
                    'example' => 'testExample',
                    'description' => 'Filter users by matching criteria.',
                ],
            ]
        ];
    }
}