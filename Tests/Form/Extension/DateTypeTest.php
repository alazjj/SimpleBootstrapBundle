<?php

namespace Alazjj\SimpleBootstrapBundle\Tests\Form\Extension;

use Alazjj\SimpleBootstrapBundle\Form\Extension\AljjazExtension;
use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

class DateTypeTest extends TypeTestCase
{
    public function testPassDatepickerOption()
    {
        $this->checkViewVars('datepicker', false, false, 'Invalid datepicker view value');
        $this->checkViewVars('datepicker', true, true, 'Invalid datepicker view value');
        $this->checkViewVars('datepicker', null, false, 'Invalid datepicker view value (form value is null)');
    }

    public function testPassWeekStartOption()
    {
        $this->checkViewVars('week_start', 2, 2, 'Invalid week_start view value');
        $this->checkViewVars('week_start', 3, 3, 'Invalid week_start view value');
        $this->checkViewVars('week_start', null, 1, 'Invalid week_start view value (form value is null)');
    }

    public function testPassViewModeOption()
    {
        $this->checkViewVars('view_mode', 0, 0, 'Invalid view_mode view value');
        $this->checkViewVars('view_mode', 'day', 'day', 'Invalid view_mode view value');
        //$this->checkViewVars('view_mode', null, false, 'Invalid view_mode view value (form value is null)');
    }

    public function testPassMinViewModeOption()
    {
        $this->checkViewVars('min_view_mode', 0, 0, 'Invalid min_view_mode view value');
        $this->checkViewVars('min_view_mode', 'day', 'day', 'Invalid min_view_mode view value');
        //$this->checkViewVars('min_view_mode', null, false, 'Invalid min_view_mode view value (form value is null)');
    }

    public function testPassHiddenOption()
    {
        $form = $this->factory->create('form', null, array(
            'datepicker' => true
        ));
        $view = $form->createView();

        $this->assertEquals('controls datepicker date input-append', $view->vars['class']);
        $this->assertEquals($view->vars['value'], $view->vars['data-date']);
    }

    public function testPassClassOption()
    {
        $form = $this->factory->create('form', null, array(
            'datepicker' => true,
            'class' => 'cssClass'
        ));
        $view = $form->createView();

        $this->assertEquals('controls cssClass datepicker date input-append', $view->vars['class']);
    }

    public function testPassFormatOption()
    {
        $form = $this->factory->create('form', null, array(
            'datepicker' => true,
            'format' => 'dd/MM/yy'
        ));
        $view = $form->createView();

        $this->assertEquals('dd/mm/yy', $view->vars['controls_attr']['data-date-format']);

        $form = $this->factory->create('form', null, array(
            'datepicker' => true,
            'format' => 'dd/MM/y'
        ));
        $view = $form->createView();

        $this->assertEquals('dd/mm/yyyy', $view->vars['controls_attr']['data-date-format']);
    }

    public function testPassAutoFormatDate()
    {
        \Locale::setDefault('en');

        $form = $this->factory->create('form', null, array(
            'datepicker' => true,
            'auto_format' => true
        ));
        $view = $form->createView();

        $this->assertEquals('m/d/yy', $view->vars['controls_attr']['data-date-format']);
    }

    /**
     * Check if the option set to the form is correctly set to the view datas
     *
     * @param $key : Option Name
     * @param $formValue : Form option value
     * @param $altViewValue : View option value
     */
    protected function checkViewVars($key, $formValue, $viewValue, $mess, $isActive = true)
    {
        $option = array();
        if ($formValue !== null) {
            $option = array($key => $formValue);
        }

        if ($isActive) {
            $option['datepicker'] = true;
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
