<?php

namespace App\Domain\Speciality\Factory;

use App\Domain\Entity\Speciality;

class SpecialityFactory
{

    public static function create(
        string $name,
        ?Speciality $parent = null
    ): Speciality
    {
        $speciality =  new Speciality();
        $speciality->setName($name);
        if ($parent) {
            $speciality->setParent($parent);
        }

        return $speciality;
    }


}