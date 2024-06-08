<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Dto\MatchingCriteriaFilterDto;
use App\Entity\Task;
use App\Entity\TaskType;
use App\Entity\User;
use App\SQLBuilder\MatchingCriteriaQueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class AssigneeTaskSetMatchingCriteriaFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'assigneeTaskSetMatchingCriteria';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
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

        $taskRepo = $this->entityManager->getRepository(Task::class);

        $tasks = $taskRepo->findBy(['taskSet'=>$value]);
        $taskTypesRepo = $this->entityManager->getRepository(TaskType::class);

        $matchingCriteria = [];
        foreach ($tasks as $task){
            $newMatchingCriteria = new MatchingCriteriaFilterDto();

            $newMatchingCriteria->taskType = (string) $taskTypesRepo->findOneBy(['name'=>$task->getTaskType()])->getId();
            $newMatchingCriteria->region = $task->getRegion();
            $newMatchingCriteria->company = $task->getCompany()->getId();
            $matchingCriteria[] = $newMatchingCriteria;
        }

        $matchingCriteriaBuilder = new MatchingCriteriaQueryBuilder();
        $matchingCriteriaBuilder->buildQuery($queryBuilder, $matchingCriteria);

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
                    'example' => 'testExample',
                    'description' => 'Filter users by matching criteria by task set.',
                ],
            ]
        ];
    }
}