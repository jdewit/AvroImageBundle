<?php
namespace Avro\ImageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/*
 * File Form Type
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class FileFormType extends AbstractType
{
    protected $showFileInput;

    public function __construct($showFileInput = true)
    {
        $this->showFileInput = $showFileInput;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (false === $this->showFileInput) {
            $style = 'display: none;';
        } else {
            $style = null;
        }

        $builder
            ->add('file', 'file', array(
                'required' => false,
                'label' => false,
                 'attr' => array(
                    'title' => 'Enter the file',
                    'data-target' => '.image-preview',
                    'style' => $style,
                    'onchange' => 'readURL(this);'
                ),
                'data_class' => 'Doctrine\MongoDB\GridFSFile'
           ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Avro\ImageBundle\Document\File',
            'cascade_validations' => true
        ));
    }

    public function getName()
    {
        return 'avro_image_image_file';
    }
}
