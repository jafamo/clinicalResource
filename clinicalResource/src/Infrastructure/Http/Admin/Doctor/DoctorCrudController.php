<?php

namespace App\Infrastructure\Http\Admin\Doctor;

use App\Domain\Entity\Doctor;
use App\Domain\Entity\MedicalCenter;
use App\Domain\Entity\Speciality;
use App\Infrastructure\Http\Admin\MedicalCenter\MedicalCenterCrudController;
use App\Infrastructure\Http\Admin\Speciality\SpecialityCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class DoctorCrudController extends AbstractCrudController
{

    /**
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Doctor::class;
    }

    public function configureFields(string $pageName): iterable
    {

        if ($pageName === Crud::PAGE_EDIT || $pageName === Crud::PAGE_NEW) {
            $centroMedico = AssociationField::new('centrosMedicos', 'Medical Center') // Relación con MedicalCenter
            ->setCrudController(MedicalCenterCrudController::class); // Opcional: Controlador específico para MedicalCenter
            $speciality = AssociationField::new('specialities', 'Speciality')
                ->setCrudController(SpecialityCrudController::class);
        } else {
            $centroMedico = CollectionField::new('centrosMedicos', 'Medical Center')
                ->SetEntryType(MedicalCenter::class);
            $speciality = CollectionField::new('specialities', 'Speciality')
                ->SetEntryType(Speciality::class);
        }
        return [
            'name',
            'surname',
            'phone',
            'openingTimes',
            $centroMedico,
            $speciality,
            'notes'
        ];

    }

    public function createEntity(string $entityFqcn)
    {
        return new Doctor();
    }
}