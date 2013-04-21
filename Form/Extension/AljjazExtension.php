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

namespace Alazjj\SimpleBootstrapBundle\Form\Extension;

use Alazjj\SimpleBootstrapBundle\Form\Extension\Type\ChoiceTypeExtension;
use Alazjj\SimpleBootstrapBundle\Form\Extension\Type\DateTypeExtension;
use Alazjj\SimpleBootstrapBundle\Form\Extension\Type\FormTypeExtension;
use Symfony\Component\Form\AbstractExtension;

class AljjazExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    protected function loadTypeExtensions()
    {
        return array(
            new DateTypeExtension(),
            new FormTypeExtension(),
            new ChoiceTypeExtension()
        );
    }
}
