<?php

namespace App\Domain\Repository;

use App\Domain\Entity\MedicalCenter;

interface MedicalCenterRepositoryInterface
{
    public function totalItems(): int;
    public function findByName(string $name): ?MedicalCenter;
    public function save(MedicalCenter $medicalCenter, bool $flush=true): void;
}