<?php

namespace App\Infrastructure\Http\Admin\Doctor;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
            ->add('id', TextType::class)
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('email', EmailType::class)
            ->add('phone', TextType::class)
            ->add('openingTimes', TextType::class)
            ->add('linkWeb', TextType::class)
            ->add('mapWeb', TextType::class);
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
            ->addIdentifier('id')
            ->add('name')
            ->add('surname')
            ->add('email')
            ->add('phone')
            ->add('openingTimes')
            ->add('linkWeb')
            ->add('mapWeb');
    }
//
//    protected function configureShowFields(ShowMapper $show): void
//    {
//        $show->add('name');
//    }

}