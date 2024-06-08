<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\TaskSet;
use App\Repository\TaskRepository;
use App\SQLBuilder\TaskSetQueryBuilder;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class ExcludeTaskSetOfTaskFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'excludeTaskSetOfTask';

    public function __construct(
        private readonly TaskRepository $taskRepository,
        ManagerRegistry                 $managerRegistry,
        LoggerInterface                 $logger = null,
        ?array                          $properties = null,
        ?NameConverterInterface         $nameConverter = null
    )
    {
        parent::__construct($managerRegistry, $logger, $properties, $nameConverter);
    }

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
        if ($property !== self::PROPERTY_NAME || $resourceClass !== TaskSet::class) {
            return;
        }

        $taskSetId = $this->taskRepository->find($value)->getTaskSet()->getId();

        $taskSetQueryBuilder = new TaskSetQueryBuilder();
        $taskSetQueryBuilder->buildExcludeTaskSetOfTaskQuery($queryBuilder, $taskSetId);
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
                    'description' => 'Filter task sets by excluding the task set of the provided task.',
                ],
            ]
        ];
    }
}