<?php

namespace App\Application\UseCase\MedicalCenter;

use App\Domain\Entity\MedicalCenter;
use App\Domain\MedicalCenter\Factory\MedicalCenterFactory;
use App\Domain\Repository\MedicalCenterRepositoryInterface;

class CreateMedicalCenterService
{
    private MedicalCenterRepositoryInterface $medicalCenterRepository;
    private MedicalCenterFactory $medicalCenterFactory;

    public function __construct(
        MedicalCenterRepositoryInterface $medicalCenterRepository,
        MedicalCenterFactory $medicalCenterFactory
    )
    {
        $this->medicalCenterRepository = $medicalCenterRepository;
        $this->medicalCenterFactory = $medicalCenterFactory;
    }

    public function createNewMedicalCenter(string $name, ?string $phone, ?string $linkWeb, ?string $email): ?MedicalCenter
    {
        $medicalCenter = $this->medicalCenterRepository->findByName($name);
        if (!$medicalCenter) {
            $medicalCenter = MedicalCenterFactory::create($name, $linkWeb, $phone, $email);
            $this->medicalCenterRepository->save($medicalCenter);

            return $medicalCenter;

        }

        return $medicalCenter;
    }

}