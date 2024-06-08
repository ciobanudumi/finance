<?php

declare(strict_types=1);

namespace App\Util;

use App\Doctrine\Annotation\SyncMerge as Merge;
use Doctrine\ORM\EntityManagerInterface;

readonly class EntityMergeHelper
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    /**
     * @param mixed $deserializedEntity
     * @param mixed $id
     * @param string $entityClass
     * @return object|string|null
     */
    public function mergeDeserialisedEntity(mixed $deserializedEntity, mixed $id, string $entityClass): object|string|null
    {
        if (!class_exists($entityClass)) {
            return $deserializedEntity;
        }

        $classMergingInfos = $this->getMergingInfos($entityClass);
        $entityClassRepository = $this->entityManager->getRepository($entityClass);
        $existingEntity = $entityClassRepository->find($id);

        if (null !== $existingEntity) {
            foreach ($classMergingInfos as $reflectionProperty) {
                $deserializedValue = $reflectionProperty->getValue($deserializedEntity);
                $reflectionProperty->setValue($existingEntity, $deserializedValue);
            }
        }

        return $existingEntity;
    }

    /**
     * @param string $class
     * @return array
     */
    private function getMergingInfos(string $class): array
    {
        if (!class_exists($class)) {
            return [];
        }

        $reflectionClass = new \ReflectionClass($class);

        $allProperties = $reflectionClass->getProperties();
        while ($parentClass  = $reflectionClass->getParentClass()) {
            $parentClassProperties = $parentClass->getProperties(\ReflectionProperty::IS_PRIVATE);
            $allProperties = array_merge($allProperties, $parentClassProperties);
            $reflectionClass = $parentClass;
        }

        $propertyInfos = [];
        foreach ($allProperties as $reflectionProperty) {
            $attributes = array_map(fn($value): string => $value->getName(), $reflectionProperty->getAttributes());

            if (in_array(Merge::class, $attributes)) {
                $propertyInfos[$reflectionProperty->getName()] = $reflectionProperty;
            }
        }

        return $propertyInfos;
    }
}