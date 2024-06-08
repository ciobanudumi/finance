<?php

namespace App\Filter;

use Doctrine\ORM\QueryBuilder;

interface ArrayDataAbstractFilterInterface
{
     public static function getPropertyName(): string;
     public static function getResourceClass(): string;
     public function buildQueryBuilder(QueryBuilder $queryBuilder, array $data): void;
}