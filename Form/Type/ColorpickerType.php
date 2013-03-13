<?php

namespace Alazjj\SimpleBootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ColorpickerType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'widget' => 'single_text',
                'attr'   => array(
                    'class'           => 'input-small',
//                    'pickerContainer' => array(
//                        'class'  => 'input-append colorpicker',
//                        'format' => 'hex'
//                    )
                ),
            )
        );
    }

    public function getParent()
    {
        return 'field';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'colorpicker';
    }

}
