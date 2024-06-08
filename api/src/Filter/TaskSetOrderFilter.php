<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\MultiOrderDto;
use App\Entity\TaskSet;
use App\SQLBuilder\TaskSetQueryBuilder;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TaskSetOrderFilter extends AbstractFilter
{
    const PROPERTY_NAME = 'taskSetOrder';

    public function __construct(
        private readonly SerializerInterface    $serializer,
        private readonly ValidatorInterface $validator,
        ManagerRegistry                         $managerRegistry,
        LoggerInterface                         $logger = null,
        ?array                                  $properties = null,
        ?NameConverterInterface                 $nameConverter = null)
    {
        parent::__construct($managerRegistry, $logger, $properties, $nameConverter);
    }
    /**
     * @param string $property
     * @param mixed $value
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param Operation|null $operation
     * @param array $context
     * @return void
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

        /** @var MultiOrderDto $multiOrders */
        $multiOrders = $this->serializer->deserialize($value, MultiOrderDto::class, "json");
        $this->validator->validate($multiOrders);

        $taskSetQueryBuilder = new TaskSetQueryBuilder();
        $taskSetQueryBuilder->buildTaskSetOrderQueryBuilder($queryBuilder, $multiOrders);
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            self::PROPERTY_NAME => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'example' => 'true',
                    'description' => 'Multi order task set.',
                ],
            ]
        ];
    }

}