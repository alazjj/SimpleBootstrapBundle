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
        $this->checkViewVars($valueBinded, $this->choices[$valueBinded]);
        $this->checkViewVars($valueBinded, $valueBinded, true);
    }

    protected function checkViewVars($valueBinded, $value, $isActive = false)
    {
        $form = $this->factory->create('choice', null, array(
            'choices' => $this->choices,
            'is_active' => $isActive,
        ));
        $form->bind($valueBinded);
        $view = $form->createView();

        $this->assertEquals($value, $view->vars['value']);
    }

    protected function getExtensions()
    {
        return array(
            new AljjazExtension()
        );
    }
}
