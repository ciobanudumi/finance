<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\ArrayDataFilterDto;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ArrayDataAbstractFilter extends AbstractFilter implements ArrayDataAbstractFilterInterface
{
    /**
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $entityManager
     * @param ManagerRegistry $managerRegistry
     * @param LoggerInterface|null $logger
     * @param array|null $properties
     * @param NameConverterInterface|null $nameConverter
     */
    public function __construct(
        protected readonly SerializerInterface $serializer,
        protected readonly ValidatorInterface $validator,
        protected readonly EntityManagerInterface $entityManager,
        ManagerRegistry $managerRegistry,
        LoggerInterface $logger = null,
        ?array $properties = null,
        ?NameConverterInterface $nameConverter = null
    ) {
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
        if ($property !== static::getPropertyName() || $resourceClass !== static::getResourceClass()) {
            return;
        }

        $data = $this->getDeserializedData($value);
        $this->buildQueryBuilder($queryBuilder, $data->data);
    }


    /**
     * @param mixed $value
     * @return ArrayDataFilterDto
     */
    protected function getDeserializedData(mixed $value): ArrayDataFilterDto
    {
        /** @var ArrayDataFilterDto $data */
        $data = $this->serializer->deserialize($value, ArrayDataFilterDto::class, "json");
        $this->validator->validate($data);

        return $data;
    }
}