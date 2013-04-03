<?php

namespace Alazjj\SimpleBootstrapBundle\Form\Extension\Type;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ChoiceTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('is_active', $options)) {
            if (!$options['is_active']) {
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
