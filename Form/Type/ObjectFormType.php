<?php
namespace Avro\ImageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/*
 * Object Form Type
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class ObjectFormType extends AbstractType
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('images', 'collection', array(
                'required' => false,
                'type' => new \Avro\ImageBundle\Form\Type\ImageFormType(),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'options' => array('data_class' => 'Avro\ImageBundle\Document\Image'),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'cascade_validations' => true
        ));
    }

    public function getName()
    {
        return 'avro_image_object';
    }
}
