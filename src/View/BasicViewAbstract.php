<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\View;

/**
 * The BasicViewInterface is the mvc component in charge of making the views,
 * and do all the stuff relation with that.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
abstract class BasicViewAbstract implements BasicViewInterface {

    /**
     * Configuration object.
     *
     * @var ParametersInterface
     */
    public $config;

    /**
     * List of vars that we will include into the view.
     *
     * @var array
     */
    public $viewVars = array();

    /**
     * String var with the name of template to be use.
     *
     * @var string
     */
    public $template = null;

    /**
     * String var with the root path of the view folder.
     *
     * @var string
     */
    public $viewsFolder = '';

    /**
     * String var with the styles path.
     *
     * @var string
     */
    public $styles = '';

    /**
     * String var with the scripts path.
     *
     * @var string
     */
    public $scripts = '';

    /**
     * The view content.
     *
     * @var string
     */
    public $contentView = '';

    /**
     * Script vars to include in the JS.
     *
     * @var string
     */
    public $scriptVars = '';

    /**
     *
     * @param ParametersInterface $config
     */
    public function __construct(\Mmf\Parameter\ParametersInterface $config) {
        $this->config = $config;
        $this->viewsFolder = $this->config->get('URLBase') . $this->config->get('mvc')['viewFolder'];
    }

    /**
     * Include Vars to the view.
     *
     * @param string $name
     * @param mixed $value
     */
    public function addVar($name, $value) {
        $this->viewVars[$name] = $value;
    }

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
    public function get($name, $template = '', $vars = array(), $globalScriptVars = '') {
        if ($template !== '') {
            $this->setTemplate($template);
        }
        //Creation the full path of the view
        $path = $this->viewsFolder . '/html/' . $name;
        //If exists vars to assign, we assing one by one.
        $viewVars = (count($vars) > 0) ? $vars : $this->viewVars;

        //Include the style if exists some style to include
        if (isset($this->styles)) {
            $vars['styles'] = $this->styles;
        }

        //Finalmente, incluimos la plantilla con las variables de los scripts.
        $this->contentView = $this->getFileContent($path, $viewVars) . $globalScriptVars;
        return $this;
    }

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
    public function addJsVar($vars, $value, $encode = false) {
        if (is_array($vars)) {
            foreach ($vars as $key => $value) {
                // if JSONencode it's enable then is because it doesn't want json_encode.
                $this->addJsVar($key, $value);
            }
        } else { // apply the logic
            $this->scriptVars = $this->scriptVars . "var $vars = " . ($encode ? json_encode($value) : $value) . ";";
        }
    }

    /**
     * Add Script into the cue of Script vars.
     *
     * @param string $jsfile
     * @param bool $min
     * @param string $type
     */
    public function addScript($jsfile, $min = FALSE, $type = 'text/javascript') {
        //Check if we must minified the style
        $minTag = "<script type='$type' src='min/?f=" . $this->asset($jsfile, TRUE) . "' ></script>";
        $maxTag = "<script type='$type' src='" . $this->asset($jsfile, TRUE) . "' ></script>";

        //TODO: min files
        $includeTag = $maxTag;


        $minPos = strpos($this->scripts, $minTag);
        $maxPos = strpos($this->scripts, $maxTag);

        if ($minPos === FALSE && $maxPos === FALSE) {  // Si no esta, concatenamos
            $this->scripts .= $includeTag;
        }
    }

    /**
     * Add Style into the cue of style vars.
     *
     * @param string $cssfile
     * @param bool $min
     */
    public function addStyles($cssfile, $min = FALSE) {
        //Check if we must minified the style
        $minTag = "<link href='min/?f=" . $this->asset($cssfile, TRUE) . "' rel='stylesheet' type='text/css'/>";
        $maxTag = "<link href='" . $this->asset($cssfile, TRUE) . "' rel='stylesheet' type='text/css'/>";

        //TODO: min styles
        $includeTag = $maxTag;


        $minPos = strpos($this->styles, $minTag);
        $maxPos = strpos($this->styles, $maxTag);

        //If it doesn't exist, we concat with the actual styles
        if ($minPos === FALSE && $maxPos === FALSE) {
            $value = $this->styles . $includeTag;
            $this->styles = $value;
        }
    }

    /**
     * Set the template to use for the returned view.
     *
     * @param string $template
     */
    public function setTemplate($template) {
        $this->template = $template;
    }

    /**
     * Get the content of the view with the template vars replace it.
     *
     * @param string $path
     * @param array  $vars
     *
     * @return string
     */
    protected function getFileContent($path, $vars = array()) {

        //If there is vars to assign.
        if (is_array($vars)) {
            foreach ($vars as $key => $value) {
                /* @var $value BasicViewInterface */
                //If is a view, get the content of the view.
                if (is_object($value) && is_a($value, '\Mmf\View\BasicViewInterface')) {
                    $$key = $value->getContentView();
                } else {
                    $$key = $value;
                }
            }
        }
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include($path);
        $output = ob_get_clean();
        return $output;
    }

    /**
     * Get the view content but included into a template.
     *
     * @return string
     * @throws Exception
     */
    public function getContentWithTemplate() {
        $vars = $this->viewVars;
        //If there is vars to assign.
        if (is_array($vars)) {
            foreach ($vars as $key => $value) {
                /* @var $value BasicViewInterface */
                //If is a view, get the content of the view.
                if (is_object($value) && is_a($value, '\Mmf\View\BasicViewInterface')) {
                    $$key = $value->getContentView();
                } else {
                    $$key = $value;
                }
            }
        }

        $content = $this->getContentView();
        if ($this->template == "") {
            $output = $content;
        } else {
            $scripts = '';
            if (strlen($this->scriptVars) > 0) {
                $scripts = "<script>/* Global Vars */".$this->scriptVars."</script>";
            }
            $styles = $this->getAllCss();
            $scripts .= $this->getAllScripts();
            ob_start();
            $path = $this->viewsFolder . '/template/' . $this->template;

            if (file_exists($path)) {
                /** @noinspection PhpIncludeInspection */
                include ($path);
            } else {
                $output = ob_get_clean();
                throw new \Exception('Template does not exists', 1502);
            }

            $output = ob_get_clean();
        }
        return $output;
    }

    /**
     * Get all the scripts, included the default scripts defined in the config
     * file.
     *
     * @return string with the dinamic and default scripts
     */
    public function getAllScripts() {
        $return = '';
        foreach ($this->config->get('mvc')['defaultScripts'] as $script) {
            //If the script includes the // is for example http or https absolute route
            if (strpos($script, '//') !== FALSE) {
                $return .= '<script type="text/javascript" src="' . $script . '"></script>';
            } else {
                $return .= '<script type="text/javascript" src="' . $this->asset($script, TRUE) . '"></script>';
            }
        }
        $return .= $this->scripts;
        return $return;
    }

    /**
     * Get all the styles.
     * file.
     *
     * @return string with the dinamic and default scripts
     */
    public function getAllCss() {
        $return = '';
        foreach ($this->config->get('mvc')['defaultCSS'] as $script) {
            //If the script includes the // is for example http or https absolute route
            if (strpos($script, '//') !== FALSE) {
                $return .= "<link href='" . $script . "' rel='stylesheet' type='text/css'/>";
            } else {
                $return .= "<link href='" . $this->asset($script, TRUE) . "' rel='stylesheet' type='text/css'/>";
            }
        }
        $return .= $this->styles;
        return $return;
    }

    /**
     * Return or Echo the install folder.
     *
     * @param string $path path from install path
     * @param bool $return (return=FALSE) if it's true, the result is returned.
     * @return string | void
     */
    public function asset($path = "/", $return = FALSE) {
        $installFolder = $this->config->get('mvc')['installFolder'];
        if (!$return) {
            echo $installFolder . $path;
        }
        return $installFolder . $path;
    }

    /**
     * Return the content view of the view.
     *
     * @return string contentView
     */
    public function getContentView() {
        return $this->contentView;
    }

}
