<?php

namespace Alazjj\SimpleBootstrapBundle\Form\Extension;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\ReversedTransformer;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class FormExtension extends AbstractTypeExtension
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
                $view->vars['value_block_name'] = 'value_block_' . $view->vars['name'];
            }
//            $formBuilder = $form->getConfig();
//            $formType = $form->getConfig()->getType();
//            if ($formType->getName() == 'date') {
//                $dateAsArray = $view->vars['value'];
//                //var_dump($dateAsArray);exit;
//                $view->vars['value'] = date(
//                    $options['format'],
//                    mktime(0, 0, 0, (int)$dateAsArray['month'], (int)$dateAsArray['day'], (int)$dateAsArray['year'])
//                );
//            }
        }
    }
}
