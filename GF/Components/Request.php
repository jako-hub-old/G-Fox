<?php
/**
 * This class is the route represents the current request, it stores information about
 * the request.
 * @package GF\Components
 * @author  Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2017 Jakolab
 */

namespace GF\Components;

use \GF\WebApplication;

class Request {
    /**
     * Types of request.
     */
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';
    /**
     * The method send by the browser.
     * @var string
     */
    private $realRequestMethod;
    /**
     * Type of request.
     * @var int
     */
    private $type;
    /**
     * Invoked route.
     * @var
     */
    private $route;
    /**
     * The params passed to the current route.
     * @var array
     */
    private $params;
    /**
     * The action assigned to the route.
     * @var callable
     */
    private $requestedAction;
    /**
     * Requested controller.
     * @var string
     */
    private $controllerName = null;
    /**
     * Requested action.
     * @var string
     */
    private $controllerAction = null;
    /**
     * Requested callback.
     * @var string
     */
    private $controllerCallable = null;
    /**
     * If the request is a callback.
     * @var bool
     */
    private $isCallable = false;
    /**
     * @var \GF\WebApplication
     */
    private $app;

    public function __construct(WebApplication &$application){
        $this->app = $application;
    }
    /**
     * This function initializes the request component.
     */
    public function init(){
        $this->type = Route::getTypeOfRequest();
        $this->route = Route::getInvokedRoute();
        $this->params = Route::getRouteParams();
        $this->requestedAction = Route::getAction();
        $this->realRequestMethod = $this->app->Server()->Method();
    }

    /**
     * This function dispatches the request.
     */
    public function dispatch(){
        if($this->route == null)
            throw new \Exception("The route does not exists");
        else if($this->realRequestMethod !== $this->type)
            throw new \Exception("Not allowed method", 1);
        else if(!isset($this->requestedAction[0]))
            throw new \Exception("There is not params for the current request!");
        if(is_callable($this->requestedAction[0])){
            $this->controllerCallable = $this->requestedAction[0];
            $this->isCallable = true;
        } else if(is_string($this->requestedAction[0])){
            $this->controllerName = $this->requestedAction[0];
            $this->controllerAction = $this->requestedAction[1]?? "index";
            $this->app->loadController($this->controllerName, $this->controllerAction);
        } else {
            throw new \Exception("Not a valid request");
        }
    }

    /**
     * This function returns the type of request executed.
     * @return int
     */
    public function getType(){
        return $this->type;
    }

    /**
     * This function returns the route assigned to the request.
     * @return mixed
     */
    public function getRoute(){
        return $this->route;
    }

    /**
     * This function returns the params assigned to the current route.
     * @return array
     */
    public function getParams(){
        return $this->params;
    }

    /**
     * This function returns the action assigned to the current route.
     * @return callable
     */
    public function getRequestedAction(){
        return $this->requestedAction;
    }
}