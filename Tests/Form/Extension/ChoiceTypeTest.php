<?php

namespace Alazjj\SimpleBootstrapBundle\Tests\Form\Extension;

use Alazjj\SimpleBootstrapBundle\Form\Extension\AljjazExtension;
use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

class ChoiceTypeTest extends TypeTestCase
{
    /**
     * @var array Option list
     */
    private $choices = array(
        1 => 'Ursaff',
        2 => 'Cancras',
        3 => 'Carbalas'
    );

    /**
     * @var int Select option id
     */
    private $valueBinded = 3;
    private $multiValueBinded = 3;

    public function testSelectChoiceValue()
    {
        $this->checkViewVars($this->valueBinded, array($this->choices[$this->valueBinded]), array(
            'choices' => $this->choices,
            'is_active' => false,
        ));

        $this->checkViewVars($this->valueBinded, $this->valueBinded, array(
            'choices' => $this->choices,
            'is_active' => true,
        ));
    }

    public function testRadioChoiceValue()
    {
        $this->checkViewVars($this->valueBinded, array($this->choices[$this->valueBinded]), array(
            'choices' => $this->choices,
            'is_active' => false,
            'expanded' => true,
            'multiple' => false
        ));

        $this->checkViewVars($this->valueBinded, array(false, false, true), array(
            'choices' => $this->choices,
            'is_active' => true,
            'expanded' => true,
            'multiple' => false
        ));
    }

    public function testCheckboxChoiceValue()
    {
        // Wtf? Why the array values is not binded to the form ???
        $this->checkViewVars($this->multiValueBinded, array($this->choices[$this->multiValueBinded]), array(
            'choices' => $this->choices,
            'is_active' => false,
            'expanded' => true,
            'multiple' => false
        ));

        $this->checkViewVars($this->multiValueBinded, array(false, false, true), array(
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
