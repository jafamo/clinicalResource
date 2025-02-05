<?php

namespace App\Infrastructure\Http\Admin\Speciality;

use App\Domain\Entity\Speciality;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SpecialityCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Speciality::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::NEW) // Asegura que se pueda crear
            ->add(Crud::PAGE_EDIT, Action::NEW) // Permite crear desde otro formulario
            ->add(Crud::PAGE_NEW, Action::NEW); // Muestra botón de crear
    }
}