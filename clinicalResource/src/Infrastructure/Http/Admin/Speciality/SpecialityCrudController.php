<?php

namespace App\Infrastructure\Http\Admin\Speciality;

use App\Domain\Entity\Speciality;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SpecialityCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Speciality::class;
    }
}