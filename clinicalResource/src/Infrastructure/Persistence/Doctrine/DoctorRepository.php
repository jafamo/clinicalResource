<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\Doctor;
use App\Domain\Repository\DoctorRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Doctor>
 */
class DoctorRepository extends ServiceEntityRepository implements DoctorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Doctor::class);
    }

//    /**
//     * @return Doctor[] Returns an array of Doctor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Doctor
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    public function searchByCriteria(?string $criteria): array
    {
        $qb = $this->createQueryBuilder('d');

        $qb->select(
            'd.id, d.name, d.surname, d.phone, d.openingTimes, d.linkWeb, d.mapWeb',
            's.name AS specialty',
            'mc.name AS medicalCenter, mc.address AS address, mc.phoneGeneric AS genericPhone',
        )
            ->leftJoin('d.specialities', 's') // Relación Many-to-Many
            ->leftJoin('d.centrosMedicos', 'mc');// Relación Many-to-Many

        // Construir la condición para el parámetro único
        if ($criteria) {
            $qb->where(
                $qb->expr()->orX(
                    $qb->expr()->like('d.name', ':criteria'),
                    $qb->expr()->like('s.name', ':criteria')
                )
            );

            // Establecer el parámetro único
            $qb->setParameter('criteria', '%' . $criteria . '%');
        }

        $qb->setMaxResults(10);

        return $qb->getQuery()->getArrayResult();
    }

}
