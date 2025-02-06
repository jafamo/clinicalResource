<?php

namespace App\Infrastructure\Http\Admin\Doctor;

use App\Domain\Entity\Doctor;
use App\Domain\Entity\MedicalCenter;
use App\Domain\Entity\Speciality;
use App\Infrastructure\Http\Admin\MedicalCenter\MedicalCenterCrudController;
use App\Infrastructure\Http\Admin\Speciality\SpecialityCrudController;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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

            return [
                FormField::addTab('Doctor Information')
                    ->setIcon('fa fa-user-doctor')->addCssClass('optional')
                    ->setHelp('Doctor information is preferred'),
                TextField::new('name'),
                TextField::new('surname'),
                EmailField::new('email'),
                TextField::new('phone'),
                TextField::new('openingTimes'),

                FormField::addTab('Contact Information Tab')
                    ->setIcon('fa fa-hospital')->addCssClass('optional')
                    ->setHelp('Medical center is preferred'),
                $centroMedico,
                $speciality,
                FormField::addTab('Map Information Tab')
                    ->setIcon('fa fa-map')->addCssClass('optional')
                    ->setHelp('Introduce map'),
                TextareaField::new('linkWeb'),
                TextareaField::new('mapWeb'),

            ];
        }

        $centroMedico = CollectionField::new('centrosMedicos', 'Medical Center')
                ->SetEntryType(MedicalCenter::class);
        $speciality = CollectionField::new('specialities', 'Speciality')
                ->SetEntryType(Speciality::class);

        return [
            FormField::addPanel('Doctor Information')->setIcon('user'),
            TextField::new('name'),
            TextField::new('surname'),
            EmailField::new('email'),
            TextField::new('phone'),
            TextField::new('openingTimes'),
            TextareaField::new('notes'),

            FormField::addPanel('Medical Details')->setIcon('hospital'),
            $centroMedico,
            $speciality,

            FormField::addPanel('Map Information')->setIcon('map'),
            TextareaField::new('linkWeb'),
            TextareaField::new('mapWeb'),
        ];
    }



    public function createEntity(string $entityFqcn)
    {
        return new Doctor();
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
}