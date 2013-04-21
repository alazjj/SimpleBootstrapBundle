<?php
/**
 * This file is part of the SimpleBootstrap Bundle.
 *
 * @author aRn0D (Arnaud Langlade) <arn0d.dev@gmail.com>
 * @author Julien Janvier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @deprecated deprecated since version 1.2
 */

namespace Alazjj\SimpleBootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatepickerType extends AbstractType
{

    private $locale;
    private $format;
    private $weekStart;

    const WEEK_START_SUNDAY = 0; // cf http://www.eyecon.ro/bootstrap-datepicker/
    const WEEK_START_MONDAY = 1; // cf http://www.eyecon.ro/bootstrap-datepicker/

    public function __construct($locale)
    {
        $this->locale    = $locale;
        $this->format    = $this->getDatepickerFormat($locale);
        $this->weekStart = $this->getWeekStart($locale);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'widget' => 'single_text',
                'format' => \IntlDateFormatter::SHORT,
                'attr'   => array(
                    'class'               => 'input-small',
                    'data-date-format'    => $this->format,
                    'data-date-weekstart' => $this->weekStart,
                )
            )
        );
    }

    public function getParent()
    {
        return 'date';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'datepicker';
    }

    /**
     * Returns the date format depending on the user locale.
     *
     * The bootstrap datepicker JS plugin uses the following ugly pattern :
     * format       string      'mm/dd/yyyy'        the date format, combination of d, dd, m, mm, yy, yyyy.
     *
     * @param $locale
     * @return string
     */
    private function getDatepickerFormat($locale)
    {
        $dateFormat = new \IntlDateFormatter($locale, \IntlDateFormatter::SHORT, \IntlDateFormatter::NONE);
        $pattern    = strtolower($dateFormat->getPattern());

        if (preg_match('#/y$#', $pattern))
        {
            $pattern = preg_replace('#/y$#', '/yy', $pattern);
        }

        return $pattern;
    }

    /**
     * Returns the day of the week starts depending on the user locale.
     *
     * @param $locale
     * @return int
     */
    private function getWeekStart($locale)
    {
        // TODO : define it with the locale
        return self::WEEK_START_MONDAY;
    }
}
