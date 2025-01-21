<?php

namespace App\Infrastructure\Http\Admin\MedicalCenter;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MedicalCenterAdmin extends AbstractAdmin
{

    public function __construct(?string $code = null, ?string $class = null, ?string $baseControllerName = null)
    {
        parent::__construct($code, $class, $baseControllerName);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('address', TextType::class)
            ->add('phoneGeneric', TextType::class)
            ->add('email', TextType::class)
            ->add('mapLink', TextType::class)
            ->add('medicos', ModelAutocompleteType::class, [
                'property' => 'name',
                'multiple' => true
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('address')
            ->add('phoneGeneric')
            ->add('email')
            ->add('mapLink')
//            ->add('medicos', ModelAutocompleteType::class, [
//                'name' => 'name',
//                'surname' => 'surname'
//            ]);
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', 'integer', ['label' => 'Id','autoincrement' => true])
            ->add('name')
            ->add('description')
            ->add('address')
            ->add('phoneGeneric')
            ->add('email')
            ->add('mapLink');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('address')
            ->add('phoneGeneric')
            ->add('email')
            ->add('mapLink');
    }

}