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

namespace Alazjj\SimpleBootstrapBundle\Tests\Form\Extension;

use Alazjj\SimpleBootstrapBundle\Form\Extension\AljjazExtension;
use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

class DateTypeTest extends TypeTestCase
{
    public function testPassDatepickerOption()
    {
        $this->checkViewVars('datepicker', false, false, 'Invalid datepicker view value', false);
        $this->checkViewVars('datepicker', true, true, 'Invalid datepicker view value');
        $this->checkViewVars('datepicker', null, false, 'Invalid datepicker view value (form value is null)', false);
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testPassInvalidWeekStartOption()
    {
        $this->factory->create('date', null, array(
            'week_start' => 15,
            'datepicker' => true,
            'widget' => 'single_text'
        ));
    }

    public function testPassWeekStartOption()
    {
        // Set an option
        $form = $this->factory->create('date', null, array(
            'week_start' => 2,
            'datepicker' => true,
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals(
            2,
            $view->vars['controls_attr']['data-date-weekstart'],
            'Invalid week_start view value'
        );

        // Test default option
        $form = $this->factory->create('date', null, array(
            'datepicker' => true,
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals(
            1,
            $view->vars['controls_attr']['data-date-weekstart'],
            'Invalid week_start view value'
        );
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testPassInvalidViewModeOption()
    {
        $this->factory->create('date', null, array(
            'view_mode' => 15,
            'datepicker' => true,
            'widget' => 'single_text'
        ));
    }

    public function testPassViewModeOption()
    {
        // Set an int option
        $form = $this->factory->create('date', null, array(
            'view_mode' => 1,
            'datepicker' => true,
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals(
            1,
            $view->vars['controls_attr']['data-date-viewmode'],
            'Invalid week_start view value'
        );

        // Set an string option
        $form = $this->factory->create('date', null, array(
            'view_mode' => 'months',
            'datepicker' => true,
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals(
            'months',
            $view->vars['controls_attr']['data-date-viewmode'],
            'Invalid week_start view value'
        );

        // Test default option
        $form = $this->factory->create('date', null, array(
            'datepicker' => true,
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals(
            0,
            $view->vars['controls_attr']['data-date-viewmode'],
            'Invalid week_start view value'
        );
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testPassInvalidMinViewModeOption()
    {
        $this->factory->create('date', null, array(
            'min_view_mode' => 15,
            'datepicker' => true,
            'widget' => 'single_text'
        ));
    }

    public function testPassMinViewModeOption()
    {
        // Set an int option
        $form = $this->factory->create('date', null, array(
            'min_view_mode' => 1,
            'datepicker' => true,
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals(
            1,
            $view->vars['controls_attr']['data-date-minviewmode'],
            'Invalid week_start view value'
        );

        // Set an string option
        $form = $this->factory->create('date', null, array(
            'min_view_mode' => 'months',
            'datepicker' => true,
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals(
            'months',
            $view->vars['controls_attr']['data-date-minviewmode'],
            'Invalid week_start view value'
        );

        // Test default option
        $form = $this->factory->create('date', null, array(
            'datepicker' => true,
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals(
            0,
            $view->vars['controls_attr']['data-date-minviewmode'],
            'Invalid week_start view value'
        );
    }


    public function testPassHiddenOption()
    {
        $form = $this->factory->create('date', null, array(
            'datepicker' => true,
            'widget' => 'single_text',
        ));
        $form->bind('2010-06-02');
        $view = $form->createView();

        $this->assertEquals('controls datepicker date input-append', $view->vars['controls_attr']['class']);
        $this->assertEquals('2010-06-02', $view->vars['controls_attr']['data-date']);
    }

    public function testPassFormatOption()
    {
        $form = $this->factory->create('date', null, array(
            'datepicker' => true,
            'format' => 'dd/MM/yy',
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals('dd/mm/yy', $view->vars['controls_attr']['data-date-format']);

        $form = $this->factory->create('date', null, array(
            'datepicker' => true,
            'format' => 'd/M/y',
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals('d/m/yyyy', $view->vars['controls_attr']['data-date-format']);
    }

    public function testPassAutoFormatDate()
    {
        $form = $this->factory->create('date', null, array(
            'datepicker' => true,
            'auto_format' => true,
            'widget' => 'single_text'
        ));
        $view = $form->createView();

        $this->assertEquals('m/d/yy', $view->vars['controls_attr']['data-date-format']);
    }

    public function testPassAttr()
    {
        $form = $this->factory->create('date', null, array(
            'is_editable' => true,
            'datepicker' => true,
            'widget' => 'single_text',
        ));

        $view = $form->createView();

        $this->assertEquals(
            array(
                'class' => 'input-small',
                'data-form-type' => 'datepicker'
            ),
            $view->vars['attr']
        );
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
            $option['widget'] = 'single_text';
        }

        $form = $this->factory->create('date', null, $option);
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
