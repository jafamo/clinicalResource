<?php

namespace App\Infrastructure\Http\Admin\MedicalCenter;

use App\Domain\Entity\MedicalCenter;
use App\Infrastructure\Http\Admin\Doctor\DoctorCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MedicalCenterCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return MedicalCenter::class;
    }
    public function createEntity(string $entityFqcn)
    {
        return new MedicalCenter();
    }

    public function configureFields(string $pageName): iterable
    {
        if ($pageName === Crud::PAGE_EDIT || $pageName === Crud::PAGE_NEW) {
            $doctor = AssociationField::new('medicos', 'Doctors') // Relación con MedicalCenter
            ->setCrudController(DoctorCrudController::class); // Opcional: Controlador específico para MedicalCenter
        } else {
            $doctor = '';
        }
        return [
            'name',
            'description',
            'address',
            'phoneGeneric',
            'email',
            'mapLink',
            $doctor,
        ];

    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // by default, when the value of some field is `null`, EasyAdmin displays
            // a label with the `null` text. You can change that by overriding
            // the `label/null` template. However, if you have lots of `null` values
            // and want to reduce the "visual noise" in your backend, you can use
            // the following option to not display anything when some value is `null`
            // (this option is applied both in the `index` and `detail` pages)
            ->hideNullValues();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::NEW) // Asegura que se pueda crear
            ->add(Crud::PAGE_EDIT, Action::NEW) // Permite crear desde otro formulario
            ->add(Crud::PAGE_NEW, Action::NEW); // Muestra botón de crear
    }

}