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

    public function save(Doctor $doctor, bool $flush = true): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($doctor);

        if ($flush) {
            $entityManager->flush();
        }
    }


    public function searchByNameAndSurname(?string $name, ?string $surname): ?Doctor
    {
        $qb = $this->createQueryBuilder('d');

        if ($name === null && $surname === null) {
            return null;
        }

        if ($name !== null) {
            $qb->andWhere('d.name = :name')
                ->setParameter('name', $name);
        }

        if ($surname !== null) {
            $qb->andWhere('d.surname = :surname')
                ->setParameter('surname', $surname);
        }


        return $qb->getQuery()->getOneOrNullResult();
    }

    public function searchByCriteria(?string $criteria): array
    {
        $qb = $this->createQueryBuilder('d'); // Alias para Doctor

        $qb->select(
            'd.id, d.name, d.surname, d.phone, d.openingTimes, d.linkWeb, d.mapWeb',
            's.name AS specialty',
            'mc.name AS medicalCenter, mc.address AS address, mc.phoneGeneric AS genericPhone',
            'COALESCE(sub.name, s.name) AS subspecialty' // Si no hay sub, usar el nombre de la especialidad
        )
            ->leftJoin('d.specialities', 's') // Relación Many-to-Many con Speciality
            ->leftJoin('d.centrosMedicos', 'mc') // Relación Many-to-Many con MedicalCenter
            ->leftJoin('s.children', 'sub') // Relación para las subespecialidades (children)
            ->leftJoin('s.medicos', 'doctor') // Relación con los doctores (Many-to-Many), alias cambiado a 'doctor'
        ;



        // Construir la condición de búsqueda
        if ($criteria) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('LOWER(d.name)', ':criteria'), // Buscar por nombre del doctor
                    $qb->expr()->like('LOWER(d.surname)', ':criteria'), // Buscar por surname del doctor
                    $qb->expr()->like('LOWER(s.name)', ':criteria'), // Buscar por especialidad
                    $qb->expr()->like('LOWER(sub.name)', ':criteria'), // Buscar por subespecialidad
                    $qb->expr()->like('LOWER(mc.name)', ':criteria')  // Buscar por centro médico
                )
            )
                ->setParameter('criteria', '%' . strtolower($criteria) . '%');
        }

        // Evitar duplicados al hacer JOINs con relaciones ManyToMany
        $qb->groupBy('d.id, s.id, mc.id, sub.id') // Agrupar correctamente, incluyendo los grupos por especialidad y subespecialidad
        ->setMaxResults(10);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @return int
     */
    public function totalItems(): int
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
