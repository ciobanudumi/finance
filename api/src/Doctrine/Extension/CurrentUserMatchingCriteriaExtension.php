<?php

declare(strict_types=1);

namespace App\Doctrine\Extension;

use App\Entity\Company;
use App\Entity\MatchingCriteria;
use App\Entity\User;
use App\Repository\CompanyRepository;
use Doctrine\ORM\QueryBuilder;

class CurrentUserMatchingCriteriaExtension extends AbstractExtension
{
    private const PREFIX = 'cumce';

    protected function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (MatchingCriteria::class !== $resourceClass || $this->security->isGranted(User::ROLE_INTERNAL)) {
            return;
        }

        /** @var CompanyRepository $companyRepository */
        $companyRepository = $this->entityManager->getRepository(Company::class);
        /** @var User $user */
        $user = $this->security->getUser();
        $companies = $companyRepository->findByUser($user);
        $companiesIds = array_map(fn(Company $company): int => $company->getId(), $companies);

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->innerJoin($rootAlias . '.user',  self::PREFIX . 'User')
            ->innerJoin(self::PREFIX . 'User.companies',  self::PREFIX . 'Company')
            ->andWhere(self::PREFIX . 'Company.id IN (:companies)')
            ->setParameter('companies', $companiesIds);
    }
}