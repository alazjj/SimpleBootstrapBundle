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

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'is_active',
            'is_editable',
            'controls_attr'
        ));

        $resolver->setDefaults(array(
            'is_active' => true,
            'is_editable' => false,
            'controls_attr' => array()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['controls_attr'] = array_merge(
            $options['controls_attr'],
            array('class' => 'controls')
        );

        if (array_key_exists('is_editable', $options)) {
            $view->vars['is_editable'] = $options['is_editable'];
            if ($options['is_editable']) {
                $view->vars['attr']['data-form-type'] = 'input';
                $view->vars['controls_attr']['data-form'] = 'row';
            }
        }

        if (array_key_exists('is_active', $options)) {
            $view->vars['is_active'] = $options['is_active'];
            if (!$options['is_active']) {
                $formType = $form->getConfig()->getType();

                // Name of the block to be used to render the value
                $view->vars['value_block_name'] = 'value_block_' . $formType->getName();
            }
        }
    }
}
