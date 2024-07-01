<?php

namespace App\Repository;

use App\Entity\RecursiveTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecursiveTransaction>
 *
 * @method RecursiveTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecursiveTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecursiveTransaction[]    findAll()
 * @method RecursiveTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecursiveTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecursiveTransaction::class);
    }

    public function save(RecursiveTransaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RecursiveTransaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RecursiveTransaction[] Returns an array of RecursiveTransaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecursiveTransaction
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
