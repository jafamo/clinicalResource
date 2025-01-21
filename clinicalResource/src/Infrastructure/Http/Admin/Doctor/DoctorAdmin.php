<?php

namespace App\Infrastructure\Http\Admin\Doctor;

use App\Domain\Entity\MedicalCenter;
use App\Domain\Entity\Speciality;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DoctorAdmin extends AbstractAdmin
{
    public function __construct(?string $code = null, ?string $class = null, ?string $baseControllerName = null)
    {
        parent::__construct($code, $class, $baseControllerName);
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
//        // Asegúrate de que las rutas de edición estén habilitadas
//        $collection->add('edit');
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
            ->add('centrosMedicos', ModelType::class, [
                'class' => MedicalCenter::class,
                'property' => 'name',
                'multiple' => true,
                'required' => false,
            ])
            ->add('specialities', ModelType::class, [
                'class' => Speciality::class,
                'property' => 'name',
                'multiple' => true,
                'required' => false,
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
            ->addIdentifier('id', null, ['label' => 'Id'])
            ->add('name', null, [
                'label' => 'Name',
            ])
            ->add('surname', null, [
                'label' => 'Surnames',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ])
            ->add('phone', null, [
                'label' => 'Phone Number',
            ])
            ->add('openingTimes', null, [
                'label' => 'Opening Tinmes',
            ])
            ->add('linkWeb', null, [
                'label' => 'linkWeb',
            ])
            ->add('mapWeb', null, [
                'label' => 'mapWeb',
            ])
            ->add('centrosMedicos', ModelType::class, [
                'class' => MedicalCenter::class,  // Especifica la clase de la entidad relacionada
                'property' => 'name',  // Aquí defines la propiedad que deseas mostrar (puede ser 'name' o cualquier otra)
                'associated_property' => 'name', // Usa 'name' o la propiedad que desees mostrar
            ])
            ->add('specialities', ModelType::class, [
                'class' => Speciality::class,  // Especifica la clase de la entidad relacionada
                'property' => 'name',  // Aquí defines la propiedad que deseas mostrar (puede ser 'name' o cualquier otra)
                'associated_property' => 'name', // Usa 'name' o la propiedad que desees mostrar
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('name')
            ->add('surname', null, [
                'label' => 'Surnames',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ])
            ->add('phone', null, [
                'label' => 'Phone Number',
            ])
            ->add('openingTimes', null, [
                'label' => 'Opening Tinmes',
            ])
            ->add('linkWeb', null, [
                'label' => 'linkWeb',
            ])
            ->add('mapWeb', null, [
                'label' => 'mapWeb',
            ])

            ->add('specialities', FieldDescriptionInterface::TYPE_ARRAY, [
                'label' => 'Specialities',
                'data' => function ($object) {
                    // $object es la entidad que estás visualizando (por ejemplo, una especialidad)
                    // Asegúrate de que 'medicos' es una colección de objetos Medico
                    return array_map(function ($specialities) {
                        return $specialities->getName();  // Asegúrate de devolver una cadena de texto
                    }, $object->getMedicos()->toArray());  // Convierte la colección de médicos a un array de nombres
                },
                'inline' => false,
                'display' => 'values',
            ])
            ->add('centrosMedicos', FieldDescriptionInterface::TYPE_ARRAY, [
                'label' => 'centrosMedicos',
                'data' => function ($object) {
                    // Asegúrate de que 'centrosMedicos' es una colección de objetos MedicalCenter
                    return array_map(function ($centroMedico) {
                        return $centroMedico->getName();  // Asegúrate de devolver una cadena de texto
                    }, $object->getCentrosMedicos()->toArray());  // Convierte la colección de centros médicos a un array de nombres
                },
                'inline' => false,
                'display' => 'values',
            ])
        ;
    }

}