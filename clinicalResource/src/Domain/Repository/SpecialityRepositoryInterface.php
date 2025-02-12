<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Speciality;

interface SpecialityRepositoryInterface
{
    public function totalItems(): int;
    public function findByName(string $name): ?Speciality;
    public function save(Speciality $speciality, ?bool $flush=true): void;

}