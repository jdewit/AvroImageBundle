<?php
namespace Avro\ImageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/*
 * Image Form Type
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class ImageFormType extends AbstractType
{
    protected $showFileInput;

    public function __construct($showFileInput = true)
    {
        $this->showFileInput = $showFileInput;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('label', 'purified_text', array(
                //'required' => false,
                //'attr' => array(
                    //'placeholder' => 'Label',
                //)
            //))
            //->add('caption', 'purified_textarea', array(
                //'required' => false,
                //'attr' => array(
                    //'placeholder' => 'Caption',
                //)
            //))
            //->add('position', 'hidden', array(
                //'attr' => array(
                    //'class' => 'position'
                //)
            //))
            ->add('file', new FileFormType($this->showFileInput))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Avro\ImageBundle\Document\Image',
            'cascade_validations' => true
        ));
    }

    public function getName()
    {
        return 'application_core_image';
    }
}
