<?php
/**
 * This class represents the application response, it sends the output with
 * it's corresponding headers.
 * @package GF\Components
 * @author  Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017 Jakolab
 */

namespace GF\Components;

class Response{
    const ACTION_CALLABLE = 0;
    const ACTION_STRING = 1;
    const ACTION_CONTROLLER = 2;

    const CONTENT_HTML = "text/html";
    const CONTENT_JSON = "application/json";
    /**
     * The application request component.
     * @var \GF\Components\Request
     */
    private $request = null;
    /**
     * The application headers.
     * @var string
     */
    #private $headers = [];
    private $contentType;
    /**
     * The outputted content.
     * @var string
     */
    private $output = "";
    /**
     * The invoked action.
     * @var mixed
     */
    private $action = null;
    private $callable = null;
    private $controller = null;
    /**
     * @var \GF\WebApplication
     */
    private $app;
    private $headers = [];
    private $body;

    public function __construct(\GF\WebApplication &$app) {
        $this->app = $app;
        $this->contentType = self::CONTENT_HTML;
    }

    /**
     * Initialize the response.
     */
    public function init(){
        $this->resolveInvokedFunction();
        $this->loadContent();
    }

    /**
     * This function dispatch the output content.
     */
    public function dispatch(){
        echo $this->output;
    }

    private function resolveInvokedFunction(){
        $action = $this->app->Request()->getRequestedAction();
        if(!isset($action[0])) return false;
        if(is_callable($action[0])){
            $this->callable = $action[0];
        } else if(is_string($action[0])){
            $this->controller = $action[0];
            $this->action = $action[0];
        }
    }

    public function setContent(string $content){
        $this->output = $content;
    }

    /**
     * This function returns the type of action invoked
     * @return int
     */
    private function getTypeOfAction(){
        if(is_callable($this->action)) return self::ACTION_CALLABLE;
        else if($this->controller !== null) return self::ACTION_CONTROLLER;
        else return null;
    }

    /**
     * This function loads the application's content.
     */
    private function loadContent() {
        switch ($this->getTypeOfAction()){
            case self::ACTION_CALLABLE:  $this->processCallable(); break;
            case self::ACTION_CONTROLLER: $this->processController(); break;
        }
    }

    /**
     * This function process a callable action.
     */
    private function processCallable() {
        $params = array_merge([$this], $this->app->Request()->getParams());
        ob_start();
        $result = call_user_func_array($this->callable, $params);
        #$this->output = ob_get_clean();
        $str = ob_get_clean();
        $this->output = $str == ""? $result : $str;
    }

    /**
     * This function allows to
     */
    private function processController(){
        $response = call_user_func_array([$this->app->Controller(), $this->app->Action()], $this->app->Request()->getParams());
        if(is_string($response)) $this->output = $response;
    }
}