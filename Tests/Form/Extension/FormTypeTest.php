<?php

namespace Alazjj\SimpleBootstrapBundle\Tests\Form\Extension;

use Alazjj\SimpleBootstrapBundle\Form\Extension\AljjazExtension;
use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

class FormTypeTest extends TypeTestCase
{
    public function testPassIsActiveOption()
    {
        $this->checkViewVars('is_active', false);
        $this->checkViewVars('is_active', true);
    }

    public function testPassIsEditableOption()
    {
        $this->checkViewVars('is_editable', false);
        $this->checkViewVars('is_editable', true);
    }

    protected function checkViewVars($key, $value)
    {
        $form = $this->factory->create('form', null, array($key => $value));
        $view = $form->createView();

        $this->assertEquals($value, $view->vars[$key]);
    }

    protected function getExtensions()
    {
        return array(
            new AljjazExtension()
        );
    }
}
