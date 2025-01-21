<?php

namespace App\Infrastructure\Http\Admin\Doctor;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DoctorAdmin extends AbstractAdmin
{
    public function __construct(?string $code = null, ?string $class = null, ?string $baseControllerName = null)
    {
        parent::__construct($code, $class, $baseControllerName);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', TextType::class, ['required' => true])
            ->add('surname', TextType::class)
            ->add('email', EmailType::class, ['required' => true])
            ->add('phone', TextType::class)
            ->add('openingTimes', TextType::class)
            ->add('linkWeb', TextType::class)
            ->add('mapWeb', TextType::class)
            ->add('centrosMedicos', ModelAutocompleteType::class, [
                'property' => 'name',
                'multiple' => true,
                'required' => false
            ])
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('id')
            ->add('name')
            ->add('surname')
            ->add('email');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', 'integer', ['label' => 'Id','autoincrement' => true])
            ->add('name')
            ->add('surname')
            ->add('email')
            ->add('phone')
            ->add('openingTimes')
            ->add('linkWeb')
            ->add('mapWeb')
            ->add('centrosMedicos', FieldDescriptionInterface::TYPE_ARRAY, [
                'inline' => true,
                'display' => 'both',
                'key_translation_domain' => true,
                'value_translation_domain' => null
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('name');
    }

}