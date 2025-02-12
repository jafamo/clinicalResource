<?php

namespace App\Application\UseCase\Speciality;

use App\Domain\Entity\Speciality;
use App\Domain\Repository\SpecialityRepositoryInterface;
use App\Domain\Speciality\Factory\SpecialityFactory;

class CreateSpecialityService
{
    public function __construct(
        private readonly SpecialityRepositoryInterface $specialityRepository,
        private readonly SpecialityFactory $specialityFactory
    ) {}

    public function createNewSpeciality(?string $specialityName, ?Speciality $parent = null): ?Speciality
    {
        if (!$specialityName) {
            return null;
        }

        // Buscar si ya existe
        $speciality = $this->specialityRepository->findByName($specialityName);

        if (!$speciality) {
            $speciality = $this->specialityFactory->create($specialityName, $parent);
            $this->specialityRepository->save($speciality, true);

            return $speciality;
        }

        return $speciality;
    }

    public function processSubspeciality(?string $subspeciality): ?array
    {
        if (!$subspeciality) {
            return [];
        }
        if (trim($subspeciality) === '-') {
            return [];
        }

        $normalized = str_replace('/', ',', $subspeciality);
        return array_map('trim', explode(',', $normalized));
    }

}