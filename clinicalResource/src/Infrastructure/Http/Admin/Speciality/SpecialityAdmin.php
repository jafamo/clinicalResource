<?php

namespace App\Infrastructure\Http\Admin\Speciality;

use App\Domain\Entity\Doctor;
use App\Domain\Entity\Speciality;
use phpDocumentor\Reflection\Types\Integer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
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

            ->add('medicos', ModelType::class, [
                'class' => Doctor::class,
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
            ->add('parent')
            ->add('children')
//            ->add('medicos')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', 'integer', ['label' => 'Id','autoincrement' => true])
            ->add('name')
            ->add('parent')
            ->add('children')
            ->add('medicos', ModelType::class, [
                'class' => Doctor::class,  // Especifica la clase de la entidad relacionada
                'property' => 'name',  // Aquí defines la propiedad que deseas mostrar (puede ser 'name' o cualquier otra)
                'associated_property' => 'name', // Usa 'name' o la propiedad que desees mostrar
            ])

            ;

    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('name')
            ->add('parent')
            ->add('children')
            ->add('medicos', FieldDescriptionInterface::TYPE_ARRAY, [
                'label' => 'Doctors',
                'data' => function ($object) {
                    // $object es la entidad que estás visualizando (por ejemplo, una especialidad)
                    // Asegúrate de que 'medicos' es una colección de objetos Medico
                    return array_map(function ($medico) {
                        return $medico->getName();  // Asegúrate de devolver una cadena de texto
                    }, $object->getMedicos()->toArray());  // Convierte la colección de médicos a un array de nombres
                },
                'inline' => false,
                'display' => 'values',
            ])

        ;
    }

}