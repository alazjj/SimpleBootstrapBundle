<?php

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
