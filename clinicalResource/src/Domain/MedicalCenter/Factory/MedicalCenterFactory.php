<?php

namespace App\Domain\MedicalCenter\Factory;

use App\Domain\Entity\MedicalCenter;

class MedicalCenterFactory
{
    public static function create(
        string $name,
        ?string $linkWeb,
        ?string $phone,
        ?string $email
    ): MedicalCenter
    {
        $medicalCenter =new MedicalCenter();
        $medicalCenter->setName($name);
        $medicalCenter->setMapLink($linkWeb);
        $medicalCenter->setPhoneGeneric($phone);
        $medicalCenter->setEmail($email);

        return $medicalCenter;
    }
}