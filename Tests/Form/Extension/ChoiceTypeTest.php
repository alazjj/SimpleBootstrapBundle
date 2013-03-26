<?php

namespace Alazjj\SimpleBootstrapBundle\Tests\Form\Extension;

use Alazjj\SimpleBootstrapBundle\Form\Extension\AljjazExtension;
use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

class ChoiceTypeTest extends TypeTestCase
{
    private $choices = array(
        1 => 'Ursaff',
        2 => 'Cancras',
        3 => 'Carbalas'
    );

    public function testChoicesOptionExpectsArray()
    {
        $valueBinded = 3;
        $this->checkViewVars($valueBinded, $this->choices[$valueBinded], array(
            'choices' => $this->choices,
            'is_active' => false,
        ));

        $this->checkViewVars($valueBinded, $valueBinded, array(
            'choices' => $this->choices,
            'is_active' => true,
        ));

        $this->checkViewVars($valueBinded, array(false, false, true), array(
            'choices' => $this->choices,
            'is_active' => false,
            'expanded' => true,
            'multiple' => false
        ));

        $this->checkViewVars($valueBinded, array(false, false, true), array(
            'choices' => $this->choices,
            'is_active' => true,
            'expanded' => true,
            'multiple' => false
        ));
    }

    protected function checkViewVars($valueBinded, $value, array $options)
    {
        $form = $this->factory->create('choice', null, $options);
        $form->bind($valueBinded);
        $view = $form->createView();

        $this->assertEquals($value, $view->vars['value'], "Invalid display choix field value");
    }

    protected function getExtensions()
    {
        return array(
            new AljjazExtension()
        );
    }
}
