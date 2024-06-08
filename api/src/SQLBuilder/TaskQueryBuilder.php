<?php

namespace App\SQLBuilder;

use Doctrine\ORM\QueryBuilder;

class TaskQueryBuilder
{
    public function buildUniqueRegionFromTask(QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder->select('o.region')->groupBy('o.region')->orderBy('o.region');

        return $queryBuilder;
    }
}