<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Doctor;

interface DoctorRepositoryInterface
{
    public function searchByCriteria(?string $criteria): array;
    public function totalItems(): int;
    public function searchByNameAndSurname(?string $name, ?string $surname): ?Doctor;
    public function save(Doctor $doctor): void;


}