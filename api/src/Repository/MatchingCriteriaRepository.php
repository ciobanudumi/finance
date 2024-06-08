<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\MatchingCriteria;
use App\Entity\TaskType;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MatchingCriteria>
 *
 * @method MatchingCriteria|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchingCriteria|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchingCriteria[]    findAll()
 * @method MatchingCriteria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchingCriteriaRepository extends ServiceEntityRepository
{
    private QueryBuilder  $qb;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchingCriteria::class);
        $this->initQueryBuilder();
    }

    public function save(MatchingCriteria $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MatchingCriteria $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function initQueryBuilder(): void
    {
        $this->qb = $this->createQueryBuilder('m');
    }

    public function getResult(): mixed
    {
        return $this->qb->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getOneOrNullResult(): mixed
    {
        return $this->qb->getQuery()->getOneOrNullResult();
    }

    public function ofUser(User $user): self
    {
        $this->qb->andWhere('m.user = :user')
            ->setParameter('user', $user);

        return $this;
    }

    public function ofCompany(Company $company): self
    {
        $this->qb->andWhere('m.company = :company')
            ->setParameter('company', $company);

        return $this;
    }

    public function withTaskType(TaskType $taskType): self
    {
        $this->qb->andWhere('m.taskType = :taskType')
            ->setParameter('taskType', $taskType);

        return $this;
    }

    public function withOverlappingRegions(int $minRegion, int $maxRegion): self
    {
        $this->qb->andWhere('m.maxRegion >= :minRegion')
            ->andWhere('m.minRegion <= :maxRegion')
            ->setParameter('minRegion', $minRegion)
            ->setParameter('maxRegion', $maxRegion);

        return $this;
    }

//    /**
//     * @return MatchingCriteria[] Returns an array of MatchingCriteria objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MatchingCriteria
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
