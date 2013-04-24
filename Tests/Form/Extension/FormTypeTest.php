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
            'controls_attr' => array('id' => 'datepicker'),
            'is_editable' => true
        ));

        $view = $form->createView();

        $this->assertEquals(
            array(
                'id' => 'datepicker',
                'class' => 'controls',
                'data-form' => 'row'
            ),
            $view->vars['controls_attr']
        );
    }

    public function testPassAttr()
    {
        $form = $this->factory->create('form', null, array(
            'is_editable' => true
        ));

        $view = $form->createView();

        $this->assertEquals(
            array(
                'data-form-type' => 'input'
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
