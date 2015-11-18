<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Language;

/**
 * The Translator is the interface used for all the classes that want to
 * implement the logic of the translation in PHP.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class Translator implements TranslatorInterface  {

    /**
     *
     * @var string
     */
    protected $locale;

    /**
     *
     * @var string
     */
    protected $translatePath;

    /**
     * @var array
     */
    protected $translations;

    /**
     * Construct.
     *
     * @param string $locale The locale
     * @param string $translatePath The path to the translation scripts
     */
    public function __construct($locale, $translatePath) {
        $this->translatePath = $translatePath;
        $this->setLocale($locale); //Set the default locale
        $this->getTranslation($locale); //Get the translation of the default
    }

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
    public function translate($id, array $parameters = array(), $locale = null) {
        if (null === $locale) {
            $locale = $this->getLocale();
        } else {
            $this->assertValidLocale($locale);
        }
        //Get the translations
        $translations = $this->getTranslation($locale);

        //Calculate the translation and replace the parameters
        return strtr($this->getTranslationForId($id, $translations), $parameters);
    }

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
    public function translateChoice($id, $number, array $parameters = array(), $locale = null) {
        if (null === $locale) {
            $locale = $this->getLocale();
        } else {
            $this->assertValidLocale($locale);
        }
        //Get the translations
        $translations = $this->getTranslation($locale);

        //Calculate the translation and replace the parameters
        return strtr($this->getTranslationForId($id, $translations, $number), $parameters);
    }

    /**
     * Sets the current locale.
     *
     * @param string $locale The locale
     *
     * @throws \InvalidArgumentException If the locale contains invalid characters
     */
    public function setLocale($locale) {
        $this->assertValidLocale($locale);
        $this->locale = $locale;

    }

    /**
     * Returns the current locale.
     *
     * @return string The locale
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     * Returns the list of translations.
     *
     * @param string $locale
     * @return array|null
     */
    public function getTranslation($locale) {
        if (!isset($this->translations[$locale])) {
            $this->translations[$locale] = $this->getFileTranslations($locale, $this->translatePath);
        }
        return $this->translations[$locale];
    }

    /**
     * Asserts that the locale is valid, throws an Exception if not.
     *
     * @param string $locale Locale to tests
     *
     * @throws \InvalidArgumentException If the locale contains invalid characters
     */
    protected function assertValidLocale($locale) {
        if (1 !== preg_match('/^[a-z]{3,3}$/i', $locale)) {
            throw new \InvalidArgumentException(sprintf('Invalid "%s" locale.', $locale));
        }
    }

    /**
     * Get the translation array.
     *
     * @param string $locale
     * @param string $translatePath
     *
     * @throws \InvalidArgumentException
     *
     * @returns array of translations
     */
    protected function getFileTranslations($locale, $translatePath) {
        $fileToInclude = $translatePath.$locale.'.php';
        if (file_exists($fileToInclude)) {
            /** @noinspection PhpIncludeInspection */
            require $fileToInclude;
            return $translation;
        }  else {
            throw new \InvalidArgumentException('Invalid path file');
        }
    }

    /**
     * Get the translation.
     *
     * @param string  $id
     * @param array   $translationArray
     * @param int     $number
     *
     * @throws TranslateException
     *
     * @return string translation
     */
    protected function getTranslationForId($id, $translationArray, $number = 0) {
        $translation = '';
        if(isset($translationArray[$id])) { //Id all join
            $translation = $this->getBasicTranslationForId($translationArray[$id], $number);
        } else { //Id separataly
            $arrayOfIds = explode(' ', $id);
            $constructTranslateArray = $translationArray;
            foreach ($arrayOfIds as $subId) {
                if(!isset($constructTranslateArray[$subId])) {
                    throw new TranslateException('Translation id not exists.('.$id.')');
                }
                $constructTranslateArray = $constructTranslateArray[$subId];

            }
            $translation = $this->getBasicTranslationForId($constructTranslateArray, $number);
        }
        //Return the string translate with the parameters include into the placeholders
        return $translation;
    }

    /**
     * Calculate the basic translation.
     *
     * @param mixed  $translationId
     * @param int     $number
     *
     * @throws TranslateException
     *
     * @return string
     */
    private function getBasicTranslationForId($translationId, $number) {
        if(is_array($translationId) //Is array and we get the translate given for number array
            && isset($translationId[$number])
            && is_string($translationId[$number])) {
             $translation = $translationId[$number];
         } else if (is_string($translationId)) { //Is string directly
             $translation = $translationId;
         }
         return $translation;
    }
}
