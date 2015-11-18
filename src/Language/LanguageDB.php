<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Language;

/**
 * The LanguageDB, main definition for all the language managment.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class LanguageDB implements LanguageInterface {

    /**
     *
     * @var CommunicationInterface
     */
    protected $communication;

    /**
     * @var ParametersInterface
     */
    protected $config;

    /**
     *
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     *
     * @var TranslatorInterface
     */
    protected $translate;

    /**
     *
     * @var string
     */
    protected $locale;

    /**
     * Constructur and choice the initial locale if is not defined in the session.
     *
     * @param CommunicationInterface $communication
     * @param ParametersInterface    $config
     * @param ConnectionInterface    $connection (optional)
     */
    public function __construct(
        \Mmf\IO\CommunicationInterface $communication,
        \Mmf\Parameter\ParametersInterface $config,
        \Mmf\Model\ConnectionInterface $connection = null
    ) {
        //Inicialize the common objects for this class.
        $this->config        = $config;
        $this->communication = $communication;
        $this->connection    = $connection;

        //Get config parameters.
        $translateClass = $this->config->get('language')['translateClass'];
        $defaultLocale  = $this->config->get('language')['locale'][0];
        $translatePath  = $this->config->get('language')['translatePath'];
        $URLBase        = $this->config->get('URLBase');

        $locale = $defaultLocale;

        //Create the translate class for logical scripts.
        if(class_exists($translateClass)) {

            $this->translate = new $translateClass($locale, $URLBase . $translatePath);
        }
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
     * @return TranslatorInterface
     */
    public function getTranslator() {
        return $this->translate;
    }

    /**
     * @return string
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale) {
        $this->assertValidLocale($locale);
        $this->locale = $locale;
        $this->translate->setLocale($locale);
    }
}
