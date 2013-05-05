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
use \Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class CollectionTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['controls_attr']['data-form-type'] = 'collection';
    }
}
