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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class TypeaheadType extends AbstractType
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
        return 'typeahead';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'source',
            'items',
            'minLength'
        ));

        $resolver->addAllowedTypes(array(
            'source' => array('array'),
            'items' => array('int'),
            'minLength' => array('int')
        ));

        $resolver->setDefaults(
            array(
                'items' => 8,
                'minLength' => 1
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['data-provide'] = 'typeahead';
        $view->vars['attr']['autocomplete'] = 'off';

        if (array_key_exists('source', $options)) {
            $view->vars['attr']['data-source'] = json_encode($options['source']);
        }
        if (array_key_exists('items', $options)) {
            $view->vars['attr']['data-items'] = $options['items'];
        }
        if (array_key_exists('minLength', $options)) {
            $view->vars['attr']['data-minLength'] = $options['minLength'];
        }
    }
}
