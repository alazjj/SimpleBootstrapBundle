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

class TypeaheadTypeTest extends TypeTestCase
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
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testPassInvalidSourceOption()
    {
        $this->factory->create('typeahead', null, array(
            'source' => 15,
        ));
    }

    public function testPassSourceOption()
    {
        // Set an option
        $form = $this->factory->create('typeahead', null, array(
            'source' => $this->choices,
        ));
        $view = $form->createView();

        $this->assertEquals(
            json_encode($this->choices),
            $view->vars['attr']['data-source'],
            'Invalid source view value'
        );
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testPassInvalidItemsOption()
    {
        $this->factory->create('typeahead', null, array(
            'items' => 'wrongOption',
        ));
    }

    public function testPassItemsOption()
    {
        // Set an option
        $form = $this->factory->create('typeahead', null, array(
            'items' => 2,
        ));
        $view = $form->createView();

        $this->assertEquals(
            2,
            $view->vars['attr']['data-items'],
            'Invalid items view value'
        );
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testPassInvalidMinLengthOption()
    {
        $this->factory->create('typeahead', null, array(
            'minLength' => 'wrongOption',
        ));
    }

    public function testPassMinLengthOption()
    {
        // Set an option
        $form = $this->factory->create('typeahead', null, array(
            'minLength' => 5,
        ));
        $view = $form->createView();

        $this->assertEquals(
            5,
            $view->vars['attr']['data-minLength'],
            'Invalid minLength view value'
        );
    }

    protected function getExtensions()
    {
        return array(
            new AljjazExtension()
        );
    }
}
