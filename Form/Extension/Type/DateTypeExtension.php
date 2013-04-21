<?php

namespace Alazjj\SimpleBootstrapBundle\Form\Extension\Type;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToLocalizedStringTransformer;

class DateTypeExtension extends AbstractTypeExtension
{
    /** @var $locale : current locale */
    protected $locale;

    public function __construct($locale = 'en')
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'date';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'datepicker',
            'auto_format',
            'week_start',
            'view_mode',
            'min_view_mode'
        ));

        $resolver->addAllowedValues(array(
            'week_start' => range(0, 6)
        ));

        $resolver->setAllowedTypes(array(
            'view_mode' => array('int', 'string'),
            'min_view_mode' => array('int', 'string'),
            'datepicker' => array('bool'),
            'auto_format' => array('bool'),
        ));

        $resolver->setDefaults(
            array(
                'datepicker' => false,
                'datepicker' => false,
                'week_start' => 1,
                'view_mode' => 0,
                'min_view_mode' => 0,
                'attr' => array(
                    'class' => 'input-small'
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['datepicker'] = $options['datepicker'];

        if ('single_text' === $options['widget'] && $options['datepicker']) {
            $view->vars['controls_attr']['class'] .= ' datepicker date input-append';
            $view->vars['controls_attr']['data-date'] = $view->vars['value'];

            if (array_key_exists('auto_format', $options) && $options['auto_format']) {
                $dateFormat = new \IntlDateFormatter(
                    $this->locale,
                    \IntlDateFormatter::SHORT,
                    \IntlDateFormatter::NONE
                );
                $options['format'] = $dateFormat->getPattern();
            }

            if (array_key_exists('format', $options)) {
                $view->vars['controls_attr']['data-date-format'] = $this->getDatepickerFormat($options['format']);
            }

            if (array_key_exists('week_start', $options)) {
                $view->vars['controls_attr']['data-date-weekstart'] = $options['week_start'];
            }

            if (array_key_exists('view_mode', $options)) {
                $view->vars['controls_attr']['data-date-viewmode'] = $options['view_mode'];
            }

            if (array_key_exists('min_view_mode', $options)) {
                $view->vars['controls_attr']['data-date-minviewmode'] = $options['min_view_mode'];
            }
        }
    }

    /**
     * Get the datepicker format from the sf form pattern
     *
     * @param $pattern
     * @return string
     */
    protected function getDatepickerFormat($pattern)
    {
        $pattern = strtolower($pattern);
        if (preg_match('#/y$#', $pattern)) {
            $pattern = preg_replace('#/y$#', '/yyyy', $pattern);
        }

        return $pattern;
    }
}
