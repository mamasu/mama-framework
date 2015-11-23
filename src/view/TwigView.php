<?php
namespace Mmf\View;

/**
 *
 */
class TwigView extends BasicViewAbstract {

    /**
     * String var with Twig instance
     * @var string
     */
    public $twig = '';

	/**
	 * [__construct description]
	 * @param \Mmf\Parameter\ParametersInterface $config [description]
	 */
    public function __construct(\Mmf\Parameter\ParametersInterface $config) {
        $this->config = $config;
        $this->viewsFolder = $this->config->get('URLBase') . $this->config->get('mvc')['viewFolder'];


        /**
         * Based on template engine selection load its custom component
         */
		$this->loadTwig();
    }

    /**
     * Prepare Twig to be use into views
     * @return Twig instance
     */
    public function loadTwig() {

        $loader = new \Twig_Loader_Filesystem(
            array (
                $this->viewsFolder
            )
        );

        // Set up environment
        $params = array(
            //'cache' => $this->viewsFolder . "cache",
        );

        $this->twig = new \Twig_Environment($loader, $params);
    }


    /**
     * [get description]
     * @param  [type] $path             [description]
     * @param  string $template         [description]
     * @param  array  $vars             [description]
     * @param  string $globalScriptVars [description]
     * @return [type]                   [description]
     */
    public function get($path, $template = '', $vars = array(), $globalScriptVars = '') {

        if ($template !== '') {
            $this->setTemplate($template);
        }


        //If exists vars to assign, we assing one by one.
        $viewVars = (count($vars) > 0) ? $vars : $this->viewVars;

        //Include the style if exists some style to include
        if (isset($this->styles)) {
            $vars['styles'] = $this->styles;
        }

        return $this->twig->render('html/'.$path, $viewVars);
    }


}