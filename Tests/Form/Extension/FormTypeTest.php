<?php

namespace Alazjj\SimpleBootstrapBundle\Tests\Form\Extension;

use Alazjj\SimpleBootstrapBundle\Form\Extension\AljjazExtension;
use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

class FormTypeTest extends TypeTestCase
{
    public function testPassIsActiveOption()
    {
        $this->checkViewVars('is_active', false, false, 'Invalid is_active view value');
        $this->checkViewVars('is_active', true, true, 'Invalid is_active view value');
        $this->checkViewVars('is_active', null, true, 'Invalid is_active view value (form value is null)');
    }

    public function testPassIsEditableOption()
    {
        $this->checkViewVars('is_editable', false, false, 'Invalid is_editable view value');
        $this->checkViewVars('is_editable', true, true, 'Invalid is_editable view value');
        $this->checkViewVars('is_editable', null, false, 'Invalid is_editable view value (form value is null)');
    }

    public function testPassControlsAttr()
    {
        $form = $this->factory->create('form', null, array(
            'controls_attr' => array('id' => 'datepicker')
        ));

        $view = $form->createView();

        $this->assertEquals(
            array(
                'id' => 'datepicker',
                'class' => 'controls'
            ),
            $view->vars['controls_attr']
        );
    }

    /**
     * Check if the option set to the form is correctly set to the view datas
     *
     * @param $key : Option Name
     * @param $formValue : Form option value
     * @param $altViewValue : View option value
     */
    protected function checkViewVars($key, $formValue, $viewValue, $mess)
    {
        $option = array();
        if ($formValue !== null) {
            $option = array($key => $formValue);
        }

        $form = $this->factory->create('form', null, $option);
        $view = $form->createView();

        $this->assertEquals($viewValue, $view->vars[$key], $mess);
    }

    protected function getExtensions()
    {
        return array(
            new AljjazExtension()
        );
    }
}
