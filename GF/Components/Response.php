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

    public function __construct(Request &$request) {
        $this->request = $request;
        $this->contentType = self::CONTENT_HTML;
    }

    /**
     * Initialize the response.
     */
    public function init(){
        $this->action = $this->request->getRequestedAction();
        $this->output = $this->loadContent();
    }

    /**
     * This function dispatch the output content.
     */
    public function dispatch(){
        echo $this->output;
    }

    /**
     * This function returns the
     * @return int
     */
    private function getTypeOfAction(){
        if(is_callable($this->action)) return self::ACTION_CALLABLE;
        #else if(is_string($this->action))
            # If the action is an string
        #else if(is_array($this->action))
            # If the action is an array
        #
        else return null;
    }

    /**
     * This function loads the application's content.
     * @return string
     */
    private function loadContent() : string {
        switch ($this->getTypeOfAction()){
            case self::ACTION_CALLABLE: return $this->processCallable();
            default : return null;
        }
    }

    /**
     * This function process a callable action.
     * @return string
     */
    private function processCallable() : string {
        $params = array_merge([$this], $this->request->getParams());
        ob_start();
        call_user_func_array($this->action, $params);
        return ob_get_clean();
    }
}