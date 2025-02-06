<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\MedicalCenter;
use App\Domain\Repository\MedicalCenterRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MedicalCenter>
 */
class MedicalCenterRepository extends ServiceEntityRepository implements MedicalCenterRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedicalCenter::class);
    }

    /**
     * @return mixed
     */
    public function totalItems(): int
    {
        return $this->createQueryBuilder('mc')
            ->select('count(mc.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
