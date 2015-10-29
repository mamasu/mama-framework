<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\MVC;

/**
 * The BasicViewInterface is the mvc component in charge of making the views,
 * and do all the stuff relation with that.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface BasicViewInterface {

    /**
     *
     * @param ParametersInterface $config
     */
    public function __construct(\Mmf\Parameter\ParametersInterface $config);

    /**
     * Include Vars to the view.
     *
     * @param string $name
     * @param mixed $value
     */
    public function addVar($name, $value);

    /**
     * Get the view render as string.
     *
     * @param string $name path name to the view.
     * @param string $template name of the template used for this view in case
     * to be the last one to be output.
     * @param mixed $vars vars to include into the view.
     * @param mixed $globalScriptVars global scripts included in the view.
     * @return BasicViewInterface
     */
    public function get($name, $template, $vars, $globalScriptVars);


    /**
     * Add Script into the cue of Script vars.
     *
     * @param string $jsfile
     * @param bool $min
     * @param string $type
     */
    public function addScript($jsfile, $min, $type);

    /**
     * Add Style into the cue of style vars.
     *
     * @param string $cssfile
     * @param bool $min
     */
    public function addStyles($cssfile, $min);

    /**
     * Set the template to use for the returned view.
     *
     * @param string $template
     */
    public function setTemplate($template);

    /**
     * Get the view content but included into a template.
     *
     * @return string
     */
    public function getContentWithTemplate();

    /**
     * Return the content view of the view.
     *
     * @return string contentView
     */
    public function getContentView();

    /**
     * Get all the styles.
     * file.
     *
     * @return string with the dinamic and default scripts
     */
    public function getAllCss();

    /**
     * Get all the scripts, included the default scripts defined in the config
     * file.
     *
     * @return string with the dinamic and default scripts
     */
    public function getAllScripts();

    /**
     * Add a global JS variable to the view
     *
     * @param mixed $vars array(variable_name => value, ...) or simply the
     * variable name. If $value happens to be a number (or something else you
     * don't want to "json_encode()", set $encode = FALSE
     * @param string $value
     * @param bool $encode = TRUE. If we don't want to encode some variable,
     * it is mandatory to add them one by one, under the pattern
     * addJsVar( $varName, $varValue, FALSE )
     * @note remember that if $foo is a string, then json_encode($var) === $var
     */
    public function addJsVar($vars, $value, $encode);

    /**
     * Return or Echo the install folder.
     *
     * @param string $path path from install path
     * @param bool $return (return=FALSE) if it's true, the result is returned.
     * @return string | void
     */
    public function asset($path, $return);
}
