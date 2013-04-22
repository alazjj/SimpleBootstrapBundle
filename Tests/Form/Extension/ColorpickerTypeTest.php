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

class ColorpickerTypeTest extends TypeTestCase
{
    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testPassInvalidFormatOption()
    {
        $this->factory->create('colorpicker', null, array(
            'format' => 'toto'
        ));
    }

    public function testPassFormatOption()
    {
        // Set an option
        $form = $this->factory->create('colorpicker', null, array(
            'format' => 'rgb',
        ));
        $view = $form->createView();

        $this->assertEquals(
            'rgb',
            $view->vars['controls_attr']['data-color-format'],
            'Invalid week_start view value'
        );
    }

    public function testPassHiddenOption()
    {
        $form = $this->factory->create('colorpicker', null, array(
            'format' => 'hex',
        ));
        $form->bind('#FFF');
        $view = $form->createView();

        $this->assertEquals('controls input-append colorpicker color', $view->vars['controls_attr']['class']);
        $this->assertEquals('#FFF', $view->vars['controls_attr']['data-color']);
    }

    protected function getExtensions()
    {
        return array(
            new AljjazExtension()
        );
    }
}
