<?php
/**
 * This class is the base of every controller, it contains
 * the logic and functions that every controllers needs.
 *
 * @package GF\Components\Web
 * @author Jorge Alejandro Quiroz Serna (Jako) <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017, Jakolab
 */

namespace GF\Components\Web;

use \GF\System;
use \GF\Components\Response;


abstract class Controller extends WebComponent
{
    /**
     * Controllers view folder name.
     * @var string
     */
    protected $ctrlFolder;
    /**
     * Controller's invoked action.
     * @var string
     */
    protected $action;
    /**
     * Application response.
     * @var Response
     */
    protected $response;
    /**
     * Dots notation path to the controller folder.
     * @var string
     */
    protected $viewsPath;
    /**
     * Where the controller should looks for it's template.
     * @var string
     */
    protected $layoutsPath;
    /**
     * The name of the layout to be used in the current response.
     * @var string
     */
    protected $layout = "main";
    /**
     * The rendered view content.
     * @var string
     */
    protected $content;
    /**
     * The output contains the result of merging the view and the layou.
     * @var string
     */
    protected $output;
    /**
     * Variables linked to the controller.
     * @var array
     */
    protected $linkedVariables = [];
    /**
     * The main title of the page.
     * @var string
     */
    protected $pageTitle = "";
    /**
     * Commands accepted by the template engine.
     * @var array
     */
    protected $templateCommands = [
        "asset"
    ];

    public function __construct(Response &$response)
    {
        $this->response = $response;
        $this->getControllerName();
        $this->defineAttachments();
        $this->ctrlFolder = lcfirst($this->ID);
    }

    /**
     * This function initializes the controller.
     */
    public function init()
    {
        $this->viewsPath = "Views.{$this->ctrlFolder}";
        $this->layoutsPath = "Views.Layouts";
        $this->pageTitle = "{$this->ID} - " . System::app()->action();
    }

    /**
     * This function is invoked after controller initialization.
     */
    public function start()
    {
    }

    /**
     * This function sets common variables that can be used in the controller
     * via interpolation.
     */
    private function defineAttachments()
    {
        $this->linkedVariables = [
            "content",
            "pageTitle",
        ];
    }

    /**
     * This function gets the controller name from the namespace;
     */
    protected function getControllerName()
    {
        $parts = explode("\\", get_called_class());
        $this->ID = end($parts);
    }

    /**
     * This function allows to load a view content and inserted into a layout.
     * To insert a view into a layout use interpolation {{content}} inside the
     * layout.
     * @param string $view
     * @param array $params
     * @return string
     * @throws \Exception
     */
    protected function render(string $view, array $params = []): string
    {
        $path = "{$this->viewsPath}.{$view}";
        if (!System::exists($path))
            throw new \Exception("The view {$view} does not exists");
        ob_start();
        foreach ($params AS $property => $value) $$property = $value;
        require System::resolvePath($path, true);
        $this->content = ob_get_clean();
        return $this->loadLayout();
    }

    /**
     * This function allows to load the layouts content and process the linked variables.
     * @return string
     * @throws \Exception
     */
    protected function loadLayout(): string
    {
        $path = "{$this->layoutsPath}.{$this->layout}";
        if (!System::exists($path)) {
            throw new \Exception("The layout {$path} does not exists");
        }
        ob_start();
        # Goad the layout.
        require System::resolvePath($path, true);
        # Get the layout's content.
        $content = ob_get_clean();
        $this->processLikedVars($content);
        return $content;
    }

    /**
     * This function redirects to another route.
     * @param string $route
     * @param array $params
     */
    protected function redirectTo(string $route, array $params = []){
        $url = \GF\Components\Route::create($route, $params);
        header("Location: {$url}");
        System::end();
    }
    /**
     * This function sends the linked variables from the controller
     * to the view.
     * @param string $content
     */
    protected function processLikedVars(string &$content) {
        foreach ($this->linkedVariables AS $property) {
            $content = str_replace("{{{$property}}}", $this->$property, $content);
        }
    }
}