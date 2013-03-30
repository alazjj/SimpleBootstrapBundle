<?php

namespace Alazjj\SimpleBootstrapBundle\Form\Extension\Type;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class FormTypeExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return 'form';
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'is_active',
            'is_editable'
        ));

        $resolver->setDefaults(array(
            'is_active' => true,
            'is_editable' => false
        ));
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('is_editable', $options)) {
            $view->vars['is_editable'] = $options['is_editable'];
        }

        if (array_key_exists('is_active', $options)) {
            $view->vars['is_active'] = $options['is_active'];
            if (!$options['is_active']) {
                $formType = $form->getConfig()->getType();

                // Name of the block to be sued to render the value
                $view->vars['value_block_name'] = 'value_block_' . $formType->getName();

                // Maybe it is better to move it in choiceTypeExtension
                //$formType = $form->getConfig()->getType();
                if ($formType->getName() == 'choice') {
                    $choices = $options['choices'];
                    $newValue = null;

                    if (!is_array($view->vars['value'])) {
                        if (array_key_exists($view->vars['value'], $choices)) {
                            $newValue[] = $choices[$view->vars['value']];
                        }
                    } else {
                        reset($choices);
                        foreach($view->vars['value'] as $key => $checked) {
                            if ($checked) {
                                $newValue[] = current($choices);
                            }
                            next($choices);
                        }
                    }

                    $view->vars['value'] = $newValue;
                }
            }
        }
    }
}
