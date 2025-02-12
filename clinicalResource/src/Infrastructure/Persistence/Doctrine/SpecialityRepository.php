<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\Speciality;
use App\Domain\Repository\SpecialityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Speciality>
 */
class SpecialityRepository extends ServiceEntityRepository implements SpecialityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Speciality::class);
    }

//    /**
//     * @return Speciality[] Returns an array of Speciality objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Speciality
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @return int
     */
    public function totalItems(): int
    {
        return $this->createQueryBuilder('s')
            ->select('count(s.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByName(string $name): ?Speciality
    {
        $qb = $this->createQueryBuilder('s')
            ->where('s.name = :name')
            ->setParameter('name', $name)
            ->getQuery();

        return $qb->getOneOrNullResult();
    }

    public function save(Speciality $speciality, ?bool $flush = true): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($speciality);

        if ($flush) {
            $entityManager->flush();
        }
    }
}
