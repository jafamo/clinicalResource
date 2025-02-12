<?php

namespace App\Application\UseCase\Doctor;

use App\Domain\Doctor\Factory\DoctorFactory;
use App\Domain\Entity\MedicalCenter;
use App\Domain\Entity\Speciality;
use App\Domain\Repository\DoctorRepositoryInterface;

class CreateDoctorService
{
    private DoctorRepositoryInterface $doctorRepository;
    public function __construct(
       DoctorRepositoryInterface $doctorRepository
    ){
        $this->doctorRepository = $doctorRepository;
    }


    public function createDoctor(
        ?string         $name,
        ?string        $surname,
        ?string        $email,
        ?string        $phone,
        ?string        $openingTimes,
        ?string        $linkWeb,
        ?string        $mapWeb,
        ?string        $notes,
        ?MedicalCenter $medicalCenter,
        ?Speciality    $speciality
    ):void
    {


        if (trim($name) === '-' || null === $name) {
           $name = null;
        }
        if (trim($surname) === '-' || null === $surname) {
            $surname = null;
        }

        if (null === $name ) {
            $name = $surname;
            $surname = null;
        }
        if (!$name && !$surname) {
            return;//TODO retornar una exception
        }
        //primero buscar por nombre o apellido
        $doctor = $this->doctorRepository->searchByNameAndSurname($name, $surname);
        if (!$doctor) {
            $newDoctor = DoctorFactory::create(
                $name,
                $surname,
                $email,
                $phone,
                $openingTimes,
                $linkWeb,
                $mapWeb,
                $notes,
                $medicalCenter,
                $speciality
            );
            $this->doctorRepository->save($newDoctor);
        }
    }



}