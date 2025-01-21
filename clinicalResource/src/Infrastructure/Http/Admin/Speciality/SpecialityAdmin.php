<?php

namespace App\Infrastructure\Http\Admin\Speciality;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SpecialityAdmin extends AbstractAdmin
{
    public function __construct(?string $code = null, ?string $class = null, ?string $baseControllerName = null)
    {
        parent::__construct($code, $class, $baseControllerName);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', TextType::class)
            ->add('parent', TextType::class)
            ->add('children', FieldDescriptionInterface::TYPE_ARRAY, [
                'inline' => true,
                'display' => 'both',
                'key_translation_domain' => true,
                'value_translation_domain' => null
            ])
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
            ->add('parent')
            ->add('children')
            ->add('medicos')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', 'integer', ['label' => 'Id','autoincrement' => true])
            ->add('name')
            ->add('parent')
            ->add('children')
            ->add('medicos')
            ;

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