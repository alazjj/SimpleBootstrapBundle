<?php
/**
 * This file is part of the SimpleBootstrap Bundle.
 *
 * @author aRn0D (Arnaud Langlade) <arn0d.dev@gmail.com>
 * @author Julien Janvier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alazjj\SimpleBootstrapBundle\Form\Extension\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ColorpickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'colorpicker';
    }

    /**
     * See the following link to get datepicker configuration options
     * @link http://www.eyecon.ro/bootstrap-colorpicker/
     *
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'format'
        ));

        $resolver->addAllowedValues(array(
            'format' => array('hex', 'rgb', 'rgba')
        ));

        $resolver->setDefaults(
            array(
                'format' => 'hex',
                'attr'   => array(
                    'class' => 'input-small',
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['controls_attr']['class'] .= ' input-append colorpicker color';
        $view->vars['controls_attr']['data-color'] = $view->vars['value'];

        if (array_key_exists('format', $options)) {
            $view->vars['controls_attr']['data-color-format'] = $options['format'];
        }

        if (array_key_exists('is_editable', $options)) {
            $view->vars['attr']['data-form-type'] = 'colorpicker';
        }
    }
}
