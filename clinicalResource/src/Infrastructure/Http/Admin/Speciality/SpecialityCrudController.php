<?php

namespace App\Infrastructure\Http\Admin\Speciality;

use App\Domain\Entity\Speciality;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SpecialityCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Speciality::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addFieldset('Specialist')
                ->setIcon('fa fa-user')->addCssClass('optional')
                ->setHelp('If you want create Parent Specialization, you need to create a Specialization Name with  Parent Specialization empty'),
            TextField::new('name')->setLabel('Specialization Name'),
            AssociationField::new('parent')->setLabel('Parent Specialization'),
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
}