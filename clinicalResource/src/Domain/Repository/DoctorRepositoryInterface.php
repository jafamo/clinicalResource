<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Doctor;

interface DoctorRepositoryInterface
{
    public function searchByCriteria(?string $criteria): array;

}