<?php

declare(strict_types=1);

namespace App\Doctrine\Extension;

use App\Entity\MatchingCriteria;
use App\Entity\Task;
use App\Entity\TaskSet;
use App\Entity\User;
use App\Repository\TaskSetRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class CurrentUserTaskSetExtension extends AbstractExtension
{
    private const PREFIX = 'cutse';

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $resourceClass
     * @return void
     */
    protected function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (TaskSet::class !== $resourceClass || $this->security->isGranted(User::ROLE_INTERNAL)) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];

        if ($this->security->isGranted(User::ROLE_ENGINEER)) {
            $this->buildQueryBuilderForEngineer($queryBuilder, $rootAlias);
        } else {
            $this->buildQueryBuilderForOtherUsers($queryBuilder, $rootAlias);
        }
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param mixed $rootAlias
     * @return void
     */
    public function buildQueryBuilderForEngineer(QueryBuilder $queryBuilder, mixed $rootAlias): void
    {
        $matchingCriteriaRepository = $this->entityManager->getRepository(MatchingCriteria::class);
        $matchingCriteria = $matchingCriteriaRepository->findBy(['user' => $this->security->getUser()]);

        /** @var TaskSetRepository $taskSetRepository */
        $taskSetRepository = $this->entityManager->getRepository(TaskSet::class);

        $taskSets = [];
        foreach ($matchingCriteria as $matchingCriterion) {
            $taskSet = $taskSetRepository->findByMatchingCriteria($matchingCriterion);
            if ($taskSet) {
                $taskSets[] = $taskSet;
            }
        }

        $queryBuilder->andWhere($rootAlias . '.assignee = :user OR ' . $rootAlias . '.id IN (:taskSets)')
            ->setParameter('user', $this->security->getUser())
            ->setParameter('taskSets', $taskSets);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param mixed $rootAlias
     * @return void
     */
    public function buildQueryBuilderForOtherUsers(QueryBuilder $queryBuilder, mixed $rootAlias): void
    {
        $queryBuilder->innerJoin(
            Task::class,
            self::PREFIX . 'Task',
            Join::WITH,
            self::PREFIX . 'Task.taskSet = ' . $rootAlias . '.id')
            ->innerJoin(self::PREFIX . 'Task.company',  self::PREFIX . 'Company')
            ->innerJoin(self::PREFIX . 'Company.users', self::PREFIX . 'User')
            ->andWhere(self::PREFIX . 'User = :currentUser')
            ->setParameter('currentUser', $this->security->getUser());
    }
}