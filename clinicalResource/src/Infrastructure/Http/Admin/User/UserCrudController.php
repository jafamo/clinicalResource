<?php

namespace App\Infrastructure\Http\Admin\User;

use App\Domain\Entity\User;
use App\Domain\Security\Role;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn(4),
            FormField::addFieldset('User information')
                ->setIcon('fa fa-user')->addCssClass('optional')
                ->setHelp('User information'),
            IdField::new('id')->setDisabled(),
            EmailField::new('email'),
            TextField::new('password')->onlyOnForms()->setDisabled(),

            FormField::addColumn(4),
            FormField::addFieldset('Roles Information')
                ->setIcon('fa fa-user')->addCssClass('optional')
                ->setHelp('Security roles in app'),
            ChoiceField::new('roles')
                ->setChoices(Role::getAvailableRoles()) // Usa los roles definidos en la clase Role
                ->allowMultipleChoices()
                ->renderExpanded(), // Para que aparezcan como checkboxes en el formulario
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