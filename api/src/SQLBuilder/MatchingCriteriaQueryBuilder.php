<?php

namespace App\SQLBuilder;

use App\Dto\MatchingCriteriaFilterDto;
use App\Entity\MatchingCriteria;
use App\Entity\TaskType;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class MatchingCriteriaQueryBuilder
{

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $matchingCriterias
     * @return QueryBuilder
     */
    public function buildQuery(QueryBuilder $queryBuilder, array $matchingCriterias): QueryBuilder
    {
        /** @var  MatchingCriteriaFilterDto $criteria  */
        foreach ($matchingCriterias as $key => $criteria) {
            $alias = 'mc'.$key;
            $queryBuilder->innerJoin(MatchingCriteria::class, $alias, Join::WITH, $alias.'.user = o.id')
                ->andWhere($alias.'.company = :company'.$key)
                ->andWhere($alias.'.minRegion <= :region'.$key)
                ->andWhere($alias.'.maxRegion >= :region'.$key)
                ->andWhere($alias.'.taskType = :taskType'.$key)
                ->setParameter('company'.$key, $criteria->company)
                ->setParameter('region'.$key, $criteria->region)
                ->setParameter('taskType'.$key, $criteria->taskType);
        }

        $queryBuilder->groupBy('o.id');

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $column
     * @return QueryBuilder
     */
    public function buildWithMatchingCriteriaQuery(QueryBuilder $queryBuilder, string $column): QueryBuilder
    {
        $queryBuilder->innerJoin(MatchingCriteria::class, 'mc', Join::WITH, 'mc.'.$column.' = o.id')
            ->groupBy('o.id');

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $resourceClass
     * @param string $alias
     * @param string $columnJoin
     * @param array $ids
     * @return QueryBuilder
     */
    public function buildIDsMatchingCriteriaQuery(QueryBuilder $queryBuilder, string $resourceClass, string $alias, string $columnJoin, array $ids): QueryBuilder
    {
        $idsParameter = $alias.ucfirst($columnJoin).'IDs';
        $queryBuilder->innerJoin($resourceClass, $alias, Join::WITH, $alias.'.id = o.'.$columnJoin)
            ->andWhere($alias.'.id IN (:'.$idsParameter.')')
            ->setParameter($idsParameter, $ids);

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int $region
     * @return QueryBuilder
     */
    public function buildRegionMatchingCriteriaQuery(QueryBuilder $queryBuilder, int $region): QueryBuilder
    {
        $queryBuilder
            ->andWhere('o.minRegion <= :region')
            ->andWhere('o.maxRegion >= :region')
            ->setParameter('region', $region);

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int $userId
     * @param string $column
     * @return QueryBuilder
     */
    public function buildWithMatchingCriteriaForUserQuery(QueryBuilder $queryBuilder, int $userId,  string $column): QueryBuilder
    {
        $queryBuilder->andWhere('mc.user = :user')
            ->setParameter('user', $userId)
            ->groupBy('o.id');

        return $queryBuilder;
    }

    public function buildWithMatchingCriteriaOfTaskTypeQuery(QueryBuilder $queryBuilder, string $taskType, string $column): QueryBuilder
    {
        $queryBuilder->innerJoin(TaskType::class, 'tt', Join::WITH, 'mc.taskType = tt.id')
            ->andWhere('tt.name = :taskType')
            ->setParameter('taskType', $taskType);

        return $queryBuilder;
    }

    public function buildTaskTypesNamesMatchingCriteriaQuery(QueryBuilder $queryBuilder, array $taskTypes): QueryBuilder
    {
        $queryBuilder->innerJoin(TaskType::class, 'tt', Join::WITH, 'o.taskType = tt.id')
            ->andWhere('tt.name IN (:taskTypes)')
            ->setParameter('taskTypes', $taskTypes);

        return $queryBuilder;
    }
}