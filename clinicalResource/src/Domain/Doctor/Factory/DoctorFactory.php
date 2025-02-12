<?php

namespace App\Domain\Doctor\Factory;

use App\Domain\Entity\Doctor;
use App\Domain\Entity\MedicalCenter;
use App\Domain\Entity\Speciality;

class DoctorFactory
{
    public static function create(
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
    ): Doctor
    {
        $doctor = new Doctor();
        $doctor->setName($name);
        $doctor->setSurname($surname);
        $doctor->setEmail($email);
        $doctor->setPhone($phone);
        $doctor->setOpeningTimes($openingTimes);
        $doctor->setLinkWeb($linkWeb);
        $doctor->setMapWeb($mapWeb);
        $doctor->setNotes($notes);
        if ($medicalCenter) {
            $doctor->addCentroMedico($medicalCenter);
        }
        if ($speciality) {
            $doctor->addSpeciality($speciality);
        }

        return $doctor;
    }
}