<?php

namespace App\Application\Service;

use App\Domain\Repository\DoctorRepositoryInterface;

class SearchDoctorsService
{
    private DoctorRepositoryInterface $doctorRepository;

    public function __construct(DoctorRepositoryInterface $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function execute(?string $criteria): array
    {
        return $this->doctorRepository->searchByCriteria($criteria);
    }


}