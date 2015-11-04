<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Language;

/**
 * The LanguageInterface, main inteface definition for all the language managment.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface LanguageInterface {

    /**
     * Constructor.
     *
     * @param CommunicationInterface $communication
     * @param ParametersInterface $config
     * @param ConnectionInterface $connection optional
     */
    public function __construct(
        \Mmf\IO\CommunicationInterface $communication,
        \Mmf\Parameter\ParametersInterface $config,
        \Mmf\Model\ConnectionInterface $connection = null
    );

    /**
     * @return TranslatorInterface
     */
    public function getTranslator();

    /**
     * @return string
     */
    public function getLocale();

    /**
     * @param string $locale
     */
    public function setLocale($locale);
}
