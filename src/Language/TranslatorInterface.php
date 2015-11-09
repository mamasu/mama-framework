<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Language;

/**
 * The TranslatorInterface is the interface used for all the classes that want to
 * implement the logic of the translation in PHP.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface TranslatorInterface {

    /**
     * Construct.
     *
     * @param string $locale The locale
     * @param string $translatePath The path to the translation scripts
     */
    public function __construct($locale, $translatePath);

    /**
     * Translates the given message.
     *
     * @param string      $id         The message id (may also be an object that can be cast to string)
     * @param array       $parameters An array of parameters for the message
     * @param string|null $locale     The locale or null to use the default
     *
     * @throws \InvalidArgumentException If the locale contains invalid characters
     *
     * @return string The translated string
     */
    public function translate($id, array $parameters = array(), $locale = null);

    /**
     * Translates the given choice message by choosing a translation according to a number.
     *
     * @param string      $id         The message id (may also be an object that can be cast to string)
     * @param int         $number     The number to use to find the indice of the message
     * @param array       $parameters An array of parameters for the message
     * @param string|null $locale     The locale or null to use the default
     *
     * @throws \InvalidArgumentException If the locale contains invalid characters
     *
     * @return string The translated string
     */
    public function translateChoice($id, $number, array $parameters = array(), $locale = null);

    /**
     * Sets the current locale.
     *
     * @param string $locale The locale
     *
     * @throws \InvalidArgumentException If the locale contains invalid characters
     */
    public function setLocale($locale);

    /**
     * Returns the current locale.
     *
     * @return string The locale
     */
    public function getLocale();
}
